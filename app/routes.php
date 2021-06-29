<?php

use App\Controllers\UserController;
use \Zeretei\PHPCore\Http\Router;

return function (Router $router) {
    $router->get('/', function () {
        return view('welcome');
    });
    $router->get('/users', [UserController::class, 'index']);
};
