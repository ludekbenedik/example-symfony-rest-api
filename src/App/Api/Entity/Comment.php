<?php

namespace App\Api\Entity;


class Comment
{
    /** @var int */
    public $id;

    /** @var \DateTime */
    public $createdAt;

    /** @var string */
    public $author;

    /** @var string */
    public $body;


    public function __construct(int $id, \DateTime $createdAt, string $author, string $body)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->author = $author;
        $this->body = $body;
    }
}
