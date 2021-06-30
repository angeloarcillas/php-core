<?php

use App\Controllers\UserController;
use Zeretei\PHPCore\Database\Migration;
use \Zeretei\PHPCore\Http\Router;

return function (Router $router) {
    $router->get('/', function () {
        return view('welcome');
    });

    // USERCONTROLLER
    $router->get('/users', [UserController::class, 'index']);
    $router->get('/users/create', [UserController::class, 'create']);
    $router->post('/users', [UserController::class, 'store']);
    $router->get('/users/:int', [UserController::class, 'show']);
    $router->get('/users/:int/edit', [UserController::class, 'edit']);
    $router->put('/users/:int', [UserController::class, 'update']);
    $router->delete('/users/:int', [UserController::class, 'destroy']);

    $router->get('/migration', function () {
        $migration = new Migration();
        return $migration->apply();
    });
};
