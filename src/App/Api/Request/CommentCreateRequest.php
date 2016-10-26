<?php

namespace App\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;


class CommentCreateRequest
{
    /** @var string */
    public $email;

    /** @var string */
    public $author;

    /** @var string */
    public $body;


    public static function loadValidatorMetadata(ClassMetadata $classMetadata)
    {
        $classMetadata->addPropertyConstraints('email', [
            new Assert\NotBlank(),
            new Assert\Type('string'),
            new Assert\Email(),
        ]);
        $classMetadata->addPropertyConstraints('author', [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]);
        $classMetadata->addPropertyConstraints('body', [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]);
    }
}
