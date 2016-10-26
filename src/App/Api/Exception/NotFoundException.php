<?php

namespace App\Api\Exception;


class NotFoundException extends \RuntimeException
{
    public static function entityById(string $class, int $id): NotFoundException
    {
        return new static(sprintf('Entity "%s" with id "%d" not found.', $class, $id));
    }
}
