<?php

namespace App\Api\Doctrine\Handler;

use App\Api\Entity\Post as ApiPost;
use App\Api\Entity\PostListItem;
use App\Api\Exception\NotFoundException;
use App\Api\Handler\PostHandlerInterface;
use App\Api\Response\PostAllResponse;
use App\Api\Response\PostGetResponse;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;


class PostHandler implements PostHandlerInterface
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
    public function all(): PostAllResponse
    {
        $posts = $this->em->createQueryBuilder()
            ->select('p')
            ->from(Post::class, 'p')
            ->addOrderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;

        $items = [];

        /** @var Post $post */
        foreach ($posts as $post) {
            $items[] = new PostListItem($post->getId(), $post->getCreatedAt(), $post->getAuthor(), $post->getTitle());
        }

        return new PostAllResponse($items);
    }


    /**
     * {@inheritdoc}
     */
    public function get(int $id): PostGetResponse
    {
        $post = $this->getPost($id);
        $apiPost = new ApiPost($post->getId(), $post->getCreatedAt(), $post->getAuthor(), $post->getTitle(), $post->getBody());

        return new PostGetResponse($apiPost);
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
