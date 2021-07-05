<?php

use \Zeretei\PHPCore\Http\Router;

use App\Controllers\Auth\LoginController;
use \App\Controllers\Auth\RegisterController;

use \App\Controllers\PostController;

return function (Router $router) {

    $router->setHost('setup');

    $router->get('/', function () {
        return view('welcome');
    });

    // REGISTER CONTROLLER
    $router->get('/register', [RegisterController::class, 'registerForm']);
    $router->post('/register', [RegisterController::class, 'register']);

    // LOGIN CONTROLLER
    $router->get('/login', [LoginController::class, 'loginForm']);
    $router->post('/login', [LoginController::class, 'login']);

    // LOGOUT
    $router->get('/logout', fn () => session_destroy());

    // POST CONTROLLER
    $router->get('/posts', [PostController::class, 'index']);
    $router->get('/posts/create', [PostController::class, 'create']);
    $router->post('/posts', [PostController::class, 'store']);
    $router->get('/posts/:int', [PostController::class, 'show']);
    $router->get('/posts/:int/edit', [PostController::class, 'edit']);
    $router->put('/posts/:int', [PostController::class, 'update']);
    $router->delete('/posts/:int', [PostController::class, 'destroy']);

    $router->get('/migrations', function () {
        $migration = new \Zeretei\PHPCore\Database\Migration();
        ddd($migration->apply());

        //? migration rollback concept
        // $recent = $migration->apply();
        // $migration->rollback($recent);

    });

    $router->get('/fresh', fn () => app('database')->query('DROP TABLE migrations, posts, users'));
};
