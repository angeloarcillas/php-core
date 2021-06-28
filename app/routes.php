<?php

use \Zeretei\PHPCore\Http\Router;

Router::get('/', function () {
    echo "working...";
});

Router::get('/users/:int/name/:str', function ($i, $n) {
    echo $i, $n;
});
