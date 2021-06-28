<?php

use App\Controllers\UserController;
use \Zeretei\PHPCore\Http\Router;

// TODO: implement return function(Router $router) {};

Router::get('/', function () {
    return view('welcome');
});

Router::get('/users', [UserController::class, 'index']);
