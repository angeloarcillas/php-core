<?php

use \Zeretei\PHPCore\Http\Router;

Router::get('/', function () {
    return require_once __DIR__ . '/Views/welcome.view.php';
});

Router::get('/users/:int/name/:str', function ($i, $n) {
    echo $i, $n;
});
