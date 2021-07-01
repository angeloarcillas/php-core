<?php

use \Zeretei\PHPCore\Http\Router;
use \App\Controllers\UserController;
use App\Controllers\Auth\LoginController;
use \App\Controllers\Auth\RegisterController;

return function (Router $router) {
    $router->get('/', function () {
        app('session')->setFlash('email', 'Email is required');
        app('session')->setFlash('email2', 'Email is required2');
        app('session')->setFlash('email3', 'Email is required3');
        app('session')->setFlash('email4', 'Email is required4');
        return redirect('/php-core/test');
        // return view('welcome');
    });
    $router->get('/test', function () {
        ddd($_SESSION);
        return redirect('/php-core/test-2');
    });
    $router->get('/test-2', function () {
        ddd($_SESSION);
    });

    // USER CONTROLLER
    $router->get('/users', [UserController::class, 'index']);
    $router->get('/users/create', [UserController::class, 'create']);
    $router->post('/users', [UserController::class, 'store']);
    $router->get('/users/:int', [UserController::class, 'show']);
    $router->get('/users/:int/edit', [UserController::class, 'edit']);
    $router->put('/users/:int', [UserController::class, 'update']);
    $router->delete('/users/:int', [UserController::class, 'destroy']);

    // REGISTER CONTROLLER
    $router->get('/register', [RegisterController::class, 'registerForm']);
    $router->post('/register', [RegisterController::class, 'register']);

    // LOGIN CONTROLLER
    $router->get('/login', [LoginController::class, 'loginForm']);
    $router->post('/login', [LoginController::class, 'login']);

    $router->get('/logout', fn () => session_destroy());

    $router->get('/migration', function () {
        $migration = new \Zeretei\PHPCore\Database\Migration();
        return $migration->apply();
    });
};
