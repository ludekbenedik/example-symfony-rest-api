<?php

namespace App\Api\Response;


class MessageResponse
{
    /** @var string */
    public $message;


    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
