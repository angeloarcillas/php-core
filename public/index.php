<?php

use Zeretei\PHPCore\Application;
use Zeretei\PHPCore\Request;
use Zeretei\PHPCore\Router;

// import autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// import helper functions
require_once __DIR__ . '/../src/helpers.php';

// create application
Application::init();

// define routes
Router::get("/", function () {
    echo "Working...";
    ddd(Request::query());
});

// run application
Application::run();
