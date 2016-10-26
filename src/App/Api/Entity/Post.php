<?php

namespace App\Api\Entity;


class Post
{
    /** @var int */
    public $id;

    /** @var \DateTime */
    public $createdAt;

    /** @var string */
    public $author;

    /** @var string */
    public $title;

    /** @var string */
    public $body;


    public function __construct(int $id, \DateTime $createdAt, string $author, string $title, string $body)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->author = $author;
        $this->title = $title;
        $this->body = $body;
    }
}
