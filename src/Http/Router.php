<?php

namespace Zeretei\PHPCore\Http;

use \Zeretei\PHPCore\Http\Request;

class Router
{

    protected static $instance;

    /**
     * Router host
     * 
     * @var string $host
     */
    protected const HOST = 'php-core';

    /**
     * Routes placeholder
     * 
     * @var array $routes
     */
    protected static $routes;

    /**
     * Routes available request method
     * 
     * @var array $verbs
     */
    public static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'];


    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Get request
     * 
     * @param string $url
     * @param array|callable $controller
     */
    public static function get($url, $controller)
    {
        self::addRoute('GET', $url, $controller);
    }

    /**
     * Post request
     * 
     * @param string $url
     * @param array|callable $controller
     */
    public static function post($url, $controller)
    {
        self::addRoute('POST', $url, $controller);
    }


    /**
     * Match the current url with defined routes
     */
    public function resolve()
    {
        $uri = Request::uri();
        $method = Request::method();

        $controller = self::$routes[$method][$uri] ?? null;

        if (is_null($controller)) {
            throw new \Exception("Route {$uri} isn't defined.");
        }

        $controller();
        exit;
    }

    /**
     * Add a route
     * 
     * @param string $method
     * @param string $url
     * @param array|callable $controller
     */
    public static function addRoute($method, $url, $controller)
    {
        // remove extra slashes
        $url = trim(static::HOST . $url, "/");

        // sanitize url
        $url = filter_var($url, FILTER_SANITIZE_URL);

        // sanitize string
        if (is_array($controller)) {
            $controller = filter_var_array($controller, FILTER_SANITIZE_STRING);
        }

        // set route to routes placeholder
        self::$routes[$method][$url] = $controller;
    }
}
