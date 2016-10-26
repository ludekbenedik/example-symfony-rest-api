<?php

namespace App\Api\Response;

use App\Api\Entity\PostListItem;


class PostAllResponse
{
    /** @var PostListItem[] */
    public $posts;


    /**
     * @param PostListItem[] $posts
     */
    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }
}
