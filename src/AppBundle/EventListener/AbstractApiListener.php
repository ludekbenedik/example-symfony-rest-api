<?php

namespace AppBundle\EventListener;

use AppBundle\ApiRequestAttributes;
use Symfony\Component\HttpFoundation\Request;


abstract class AbstractApiListener
{
    protected function isApiRequest(Request $request): bool
    {
        return $request->attributes->has(ApiRequestAttributes::AUTHORIZE);
    }
}
