<?php

namespace App\Api\Handler;

use App\Api\Exception\NotFoundException;
use App\Api\Request\CommentCreateRequest;
use App\Api\Response\CommentAllResponse;


interface CommentHandlerInterface
{
    /**
     * @throws NotFoundException
     */
    public function all(int $postId): CommentAllResponse;

    /**
     * @throws NotFoundException
     */
    public function create(int $postId, CommentCreateRequest $request): int;
}
