<?php

namespace AppBundle\Controller\Api;

use App\Api\Handler\CommentHandlerInterface;
use App\Api\Request\CommentCreateRequest;
use AppBundle\View\ApiView;
use Symfony\Component\HttpFoundation\Response;


class CommentController
{
    /** @var CommentHandlerInterface */
    private $handler;


    public function __construct(CommentHandlerInterface $handler)
    {
        $this->handler = $handler;
    }


    public function allAction(int $postId)
    {
        return new ApiView($this->handler->all($postId));
    }


    public function postAction(int $postId, CommentCreateRequest $apiRequest)
    {
        $this->handler->create($postId, $apiRequest);

        return new Response('', Response::HTTP_CREATED);
    }
}
