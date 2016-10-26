<?php

namespace App\Api\Entity;


class PostListItem
{
    /** @var int */
    public $id;

    /** @var \DateTime */
    public $createdAt;

    /** @var string */
    public $author;

    /** @var string */
    public $title;


    public function __construct(int $id, \DateTime $createdAt, string $author, string $title)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->author = $author;
        $this->title = $title;
    }
}
