<?php

namespace App\Api\Handler;

use App\Api\Exception\NotFoundException;
use App\Api\Request\PostCreateRequest;
use App\Api\Request\PostUpdateRequest;
use App\Api\Response\PostAllResponse;
use App\Api\Response\PostGetResponse;


interface PostHandlerInterface
{
    public function all(): PostAllResponse;


    /**
     * @throws NotFoundException
     */
    public function get(int $id): PostGetResponse;
}
