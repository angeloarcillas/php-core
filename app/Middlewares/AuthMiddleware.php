<?php

namespace App\Middlewares;

use \Zeretei\PHPCore\Blueprint\Middleware;

class AuthMiddleware extends Middleware
{

    public function execute(string $action)
    {
        if (in_array($action, $this->getActions())) {
           if (! app('session')->get('auth')) {
               throw new \Exception("403 - Unauthorized. Please login or register.");
           }
        }
    }
}
