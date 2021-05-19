<?php

// no type coercion allowed
declare(strict_types=1);

// check if session started
if (session_status() === PHP_SESSION_NONE) {
    // start a session
    session_start();
}

// import Request and Router class
use Core\Http\Request;
use Core\Http\Router;

// import autoloader
require 'autoload.php';

// import helper functions
require 'Core/helper.php';

// Set app configs
$config = require 'config.php';
define('CONFIG', $config);

/**
 * Boot Router
 *
 * load() - set routes
 * direct() - match then execute route
 */
Router::load('App/routes.php')
    ->direct(Request::url(), Request::method());
