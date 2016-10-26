<?php

namespace App\Api\Response;

use App\Api\Entity\Comment;


class CommentAllResponse
{
    /** @var Comment[] */
    public $comments;


    /**
     * @param Comment[] $comments
     */
    public function __construct(array $comments)
    {
        $this->comments = $comments;
    }
}
