<?php

namespace App\Api\Response;

use App\Api\Entity\Violation;


class UnprocessableEntityResponse
{
    /** @var Violation[] */
    public $violations;


    /**
     * @param Violation[] $violations
     */
    public function __construct(array $violations)
    {
        $this->violations = $violations;
    }
}
