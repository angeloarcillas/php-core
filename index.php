<?php

declare(strict_types=1);

// Check if session started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// use Request and Router namespace
use \Core\Http\Request;
use \Core\Http\Router;

// load autoload
require 'autoload.php';

// load helper functions
require 'Core/helper.php';

// Set configs
$config = require 'config.php';
define('CONFIG', $config);

/**
 * Init Router
 *
 * load() - set routes
 * direct() - match then execute route
 */
Router::load('App/routes.php')
    ->direct(Request::url(), Request::method());