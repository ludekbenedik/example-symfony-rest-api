<?php

namespace App\Api\Entity;


class Violation
{
    /** @var string */
    public $path;

    /** @var string */
    public $message;


    public function __construct(string $path, string $message)
    {
        $this->path = $path;
        $this->message = $message;
    }
}
