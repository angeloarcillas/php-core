<?php

use Zeretei\PHPCore\Application;
use Zeretei\PHPCore\Http\Request;
use Zeretei\PHPCore\Http\Router;

// import autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// import helper functions
require_once __DIR__ . '/../src/helpers.php';

// create application
Application::init();

// define routes
Router::get("/", function () {
    echo "Working...";
    ddd(Request::uri());
});

Router::get('/users', [\App\Controllers\UserController::class, 'index']);
Router::get('/users/:int', [\App\Controllers\UserController::class, 'index']);

// run application
Application::run();
