<?php

use \Zeretei\PHPCore\Http\Router;

Router::get('/', function () {
    return view('welcome');
});

Router::get('/users/:int/name/:str', function ($i, $n) {
    echo $i, $n;
});
