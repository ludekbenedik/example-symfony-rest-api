<?php

namespace App\Entity;


class Comment
{
    private $id;
    private $createdAt;
    private $approved;
    private $post;
    private $email;
    private $author;
    private $body;


    public function __construct(Post $post, string $email, string $author, string $body)
    {
        $this->createdAt = new \DateTime();
        $this->approved = false;
        $this->post = $post;
        $this->email = $email;
        $this->author = $author;
        $this->body = $body;
    }


    public function approve()
    {
        $this->approved = true;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }


    public function isApproved(): bool
    {
        return $this->approved;
    }


    public function getPost(): Post
    {
        return $this->post;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function getAuthor(): string
    {
        return $this->author;
    }


    public function getBody(): string
    {
        return $this->body;
    }
}
