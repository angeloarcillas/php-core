<?php

use Zeretei\PHPCore\Application;
use Zeretei\PHPCore\Http\Router;

// import autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// set config
$config = [
    'root_dir' => dirname(__DIR__),
    'database' => require_once dirname(__DIR__) . '/config.php'
];

// create application instance
$app = new Application($config);

$routes = $app->ROOT_DIR . '/app/routes.php';

Router::load($routes);

// run application
$app->run();
