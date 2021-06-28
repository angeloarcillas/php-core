<?php

namespace Zeretei\PHPCore\Blueprint;

/**
 * Controller base class
 */
abstract class Controller
{

    /**
     * magic method to call undefined method
     */
    public function __call($method, $parameters)
    {
        // thorw error since method does not exists
        throw new \Exception(sprintf(
            'Method: "%s()" does not exists on %s.',
            $method,
            static::class
        ));
    }
}
