<?php

namespace App\Entity;


class Post
{
    private $id;
    private $createdAt;
    private $author;
    private $title;
    private $body;


    public function __construct(string $author, string $title, string $body)
    {
        $this->createdAt = new \DateTime();
        $this->author = $author;
        $this->title = $title;
        $this->body = $body;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }


    public function getAuthor(): string
    {
        return $this->author;
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function getBody(): string
    {
        return $this->body;
    }
}
