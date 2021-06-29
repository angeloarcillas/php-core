<?php

use App\Controllers\UserController;
use Zeretei\PHPCore\Database\Migration;
use \Zeretei\PHPCore\Http\Router;

return function (Router $router) {
    $router->get('/', function () {
        return view('welcome');
    });

    $router->get('/users', [UserController::class, 'index']);
    $router->get('/users/:int', [UserController::class, 'show']);
    $router->get('/users/create', [UserController::class, 'create']);
    $router->post('/users', [UserController::class, 'store']);

    $router->get('/migration', function () {
        $migration = new Migration();
        return $migration->apply();
    });
};
