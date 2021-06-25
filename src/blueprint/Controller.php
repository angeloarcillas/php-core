<?php

namespace Zeretei\PHPCore\Blueprint;

abstract class Controller
{

    public function __call($method, $parameters)
    {
        throw new \Exception(sprintf(
            'Method: "%s()" does not exists on %s.',
            $method,
            static::class
        ));
    }
}
