<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use \Zeretei\PHPCore\Application;
use \Zeretei\PHPCore\Http\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once dirname(__DIR__) . '/config.php';

$app = new Application($config);

$app->bind('path.app', $app->ROOT_DIR . 'app');
$app->bind('path.views', $app->ROOT_DIR . 'app/Views');
$app->bind('path.routes', $app->ROOT_DIR . 'app/routes.php');
$app->bind('path.databases', $app->ROOT_DIR . 'app/Databases');

$app->run(Request::uri(), Request::method());
