<?php

namespace AppBundle;


/**
 * Contains all dynamically created request attributes
 */
final class ApiRequestAttributes
{
    /**
     * The AUTHENTICATE attribute define if request need authentication
     *
     * Used during 'kernel.request' event.
     *
     * Required: true
     * Type: bool
     *
     * @var string
     */
    const AUTHORIZE = 'apiAuthorize';

    /**
     * The REQUEST_CLASS attribute is used for class definition of object which is set to REQUEST
     *
     * Used during 'kernel.request' event.
     *
     * Required: false
     * Type: null|string
     *
     * @var string
     */
    const REQUEST_CLASS = 'apiRequestClass';

    /**
     * The REQUEST attribute is used as argument in actions
     *
     * Attribute is set to Request attributes collection during 'kernel.request' event.
     *
     * Required: false
     * Type: null|object
     *
     * @var string
     */
    const REQUEST = 'apiRequest';


    /**
     * @param array $parameters
     * @return array
     */
    public static function normalize(array $parameters)
    {
        if (!isset($parameters[self::AUTHORIZE])) {
            throw new \LogicException(sprintf("Parameters do not contain %s key.", self::AUTHORIZE));
        }

        $normalizedParameters = [];

        $normalizedParameters[self::AUTHORIZE] = (bool) $parameters[self::AUTHORIZE];

        $normalizedParameters[self::REQUEST_CLASS] = isset($parameters[self::REQUEST_CLASS])
            ? (string) $parameters[self::REQUEST_CLASS]
            : null;

        $normalizedParameters[self::REQUEST] = null;

        return $normalizedParameters;
    }
}
