<?php

namespace AppBundle\Controller\Api;

use App\Api\Handler\PostHandlerInterface;
use AppBundle\View\ApiView;


class PostController
{
    /** @var PostHandlerInterface */
    private $handler;


    public function __construct(PostHandlerInterface $handler)
    {
        $this->handler = $handler;
    }


    public function allAction()
    {
        return new ApiView($this->handler->all());
    }


    public function getAction(int $id)
    {
        return new ApiView($this->handler->get($id));
    }
}
