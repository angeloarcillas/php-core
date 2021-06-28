<?php

use App\Controllers\UserController;
use \Zeretei\PHPCore\Http\Router;

Router::get('/', function () {
    return view('welcome');
});

Router::get('/users', [UserController::class, 'index']);
