<?php

namespace App\Api\Doctrine\Handler;

use App\Api\Entity\Comment as ApiComment;
use App\Api\Exception\NotFoundException;
use App\Api\Handler\CommentHandlerInterface;
use App\Api\Request\CommentCreateRequest;
use App\Api\Response\CommentAllResponse;
use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;


class CommentHandler implements CommentHandlerInterface
{
    /** @var EntityManagerInterface */
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * {@inheritdoc}
     */
    public function all(int $postId): CommentAllResponse
    {
        $post = $this->getPost($postId);
        $comments = $this->em->createQueryBuilder()
            ->select('c')
            ->from(Comment::class, 'c')
            ->andWhere('c.post = :post')
            ->setParameter('post', $post)
            ->andWhere('c.approved = :approved')
            ->setParameter('approved', true)
            ->addOrderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
        $apiComments = [];

        /** @var Comment $comment */
        foreach ($comments as $comment) {
            $apiComments[] = new ApiComment($comment->getId(), $comment->getCreatedAt(), $comment->getAuthor(), $comment->getBody());
        }

        return new CommentAllResponse($apiComments);
    }


    /**
     * {@inheritdoc}
     */
    public function create(int $postId, CommentCreateRequest $request): int
    {
        $post = $this->getPost($postId);
        $comment = new Comment($post, $request->email, $request->author, $request->body);

        $this->em->persist($comment);
        $this->em->flush();

        return $comment->getId();
    }


    /**
     * @throws NotFoundException
     */
    private function getPost(int $id): Post
    {
        $post = $this->em->getRepository(Post::class)->find($id);

        if (null === $post) {
            throw NotFoundException::entityById(Post::class, $id);
        }

        return $post;
    }
}
