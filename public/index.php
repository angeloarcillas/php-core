<?php

use Zeretei\PHPCore\Application;
use Zeretei\PHPCore\Http\Request;

// import autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// get config
$config = require_once dirname(__DIR__) . '/config.php';

// create application instance
$app = new Application($config);

// load all routes
$routes = $app->ROOT_DIR . '/app/routes.php';
$app->get('router')->load($routes);

// run application
$app->run(Request::uri(), Request::method());
