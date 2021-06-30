<?php

namespace App\Middlewares;

use \Zeretei\PHPCore\Blueprint\Middleware;

class AuthMiddleware extends Middleware
{

    public function execute(string $action)
    {
        if (in_array($action, $this->getActions())) {
            throw new \Exception("403 - Unauthorized");
        }
    }
}
