<?php

namespace AppBundle\View;

use Symfony\Component\HttpFoundation\Response;


class ApiView
{
    /** @var object */
    private $object;

    /** @var int */
    private $httpStatus;


    /**
     * @param object $object
     */
    public function __construct($object, int $httpStatus = Response::HTTP_OK)
    {
        $this->object = $object;
        $this->httpStatus = $httpStatus;
    }


    /**
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }


    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }
}
