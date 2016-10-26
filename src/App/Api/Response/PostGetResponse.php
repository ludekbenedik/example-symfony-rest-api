<?php

namespace App\Api\Response;

use App\Api\Entity\Post;


class PostGetResponse
{
    /** @var Post */
    public $post;


    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
