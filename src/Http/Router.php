<?php

namespace Zeretei\PHPCore\Http;

use \Zeretei\PHPCore\Http\Request;
use \Zeretei\PHPCore\Http\Traits\Route;
use \Zeretei\PHPCore\Http\Traits\RouterController;

class Router
{
    use Route;
    use RouterController;

    /**
     * Router instance
     * 
     * @var self
     */
    protected static self $instance;

    /**
     * Router host
     * 
     * @var string
     */
    protected const HOST = 'php-core';

    /**
     * Routes placeholder
     * 
     * @var array
     */
    protected static array $routes;

    /**
     * Routes available request method
     * 
     * @var array
     */
    protected static array $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'];



    /**
     * Router attributes placeholder
     */
    protected array $attributes = [];

    /**
     * Get Router instance
     */
    public static function getInstance(): Router
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
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
            return $controller(...$this->attributes);
        }

        return $this->callAction($controller);
    }

    /**
     * Add a route
     * 
     * @param string $method
     * @param string $url
     * @param array|callable $controller
     */
    protected static function addRoute(string $method, string $url, array|callable $controller): void
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
