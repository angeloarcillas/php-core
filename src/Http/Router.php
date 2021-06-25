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
    protected static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'];

    protected $patterns = [
        ":int" => "(\d+)",
        ":char" => "([a-zA-Z]+)",
        ":str" => "(\w+)",
        ":any" => "(.+)",
    ];

    protected $attributes;


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
        $method = $_POST["_method"] ?? Request::method();
        $controller = static::$routes[$method][$uri] ?? null;

        if (is_null($controller)) {
            $routesWithWildcard = $this->getRoutesWithWildcard(static::$routes[$method]);
            foreach ($routesWithWildcard as $route => $action) {
                if ($this->matchWildcard($route, $uri)) {
                    $controller = $action;
                    break;
                }
            }
        }

        if (is_null($controller)) {
            Response::setStatusCode(404);
            throw new \Exception(sprintf('Route: "%s" is not defined.', $uri));
        }

        if (is_callable($controller)) {
            $controller(...$this->attributes);
            exit;
        }

        [$controller, $action] = [...$controller, null];

        if (!class_exists($controller)) {
            throw new \Exception(
                sprintf('Controller: "%s" does not exists.', $controller)
            );
        }

        $class = new $controller();

        if (is_null($action)) {
            return $this->callInvoke($class);
        }

        return $class->$action(...$this->attributes);
    }


    /**
     * Add a route
     * 
     * @param string $method
     * @param string $url
     * @param array|callable $controller
     */
    protected static function addRoute($method, $url, $controller)
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

    public function getRoutesWithWildcard($routes)
    {
        $hasWildcard = fn ($_v, $route) => str_contains($route, ':');
        return array_filter($routes, $hasWildcard, ARRAY_FILTER_USE_BOTH);
    }

    protected function matchWildcard($route, $url)
    {
        // wildcard to search
        $searches = array_keys($this->patterns);
        // regex to replace wildcard
        $replaces = array_values($this->patterns);
        // create regex to match uri
        $regex = str_replace($searches, $replaces, $route);

        // match regex with route
        if (preg_match("#^{$regex}$#", $url, $values)) {
            // pop the full url then set attributes
            $this->attributes = array_slice($values, 1); // refactor
            return true;
        }

        return false;
    }

    protected function callInvoke($class)
    {
        if (!is_callable($class)) {
            throw new \Exception(
                sprintf('Method: "__invoke" does not exists on %s.', $class::class)
            );
        }

        return $class();
    }
}
