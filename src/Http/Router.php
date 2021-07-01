<?php

namespace Zeretei\PHPCore\Http;

use \Zeretei\PHPCore\Http\Traits\Route;
use \Zeretei\PHPCore\Http\Traits\RouterController;

class Router
{
    use Route;
    use RouterController;

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
    protected static array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => [],
    ];

    /**
     * Routes available request method
     * 
     * @var array
     */
    protected static array $verbs = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];



    /**
     * Router attributes placeholder
     */
    protected array $attributes = [];

    /**
     * Match the current url with defined routes
     */
    public function resolve($uri, $method)
    {
        // get request method
        $method = $_POST["_method"] ?? $method;

        if (!$this->isValidVerb($method)) {
            throw new \Exception(sprintf('Request Method: "%s" is not a valid method.', $method));
        }

        // get callback
        $callback = static::$routes[$method][$uri] ?? null;

        if (is_null($callback)) {
            // get routes w/ wildcard
            $routesWithWildcard = $this->getRoutesWithWildcard(static::$routes[$method]);

            // loop through routes
            foreach ($routesWithWildcard as $route => $action) {
                // check if uri & route match
                if ($this->matchWildcard($route, $uri)) {
                    // set callback
                    $callback = $action;
                    break;
                }
            }
        }

        // check if route found
        if (is_null($callback)) {
            Response::setStatusCode(404);
            throw new \Exception(sprintf('Method: %s on Route: "%s" is not defined.', $method, $uri));
        }

        // check if callback is callable
        if (is_callable($callback)) {
            return $callback(...$this->attributes);
        }

        return $this->callAction($callback);
    }

    /**
     * Add a route
     * 
     * @param string $method
     * @param string $url
     * @param array|callable $controller
     */
    protected function addRoute(string $method, string $url, array|callable $controller): void
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

    /**
     * Check request method if valid.
     */
    public function isValidVerb(string $method): bool
    {
        return in_array($method, static::$verbs);
    }

    /**
     * Redirect back to previous url
     */
    public function back(): void
    {
        // check if previous uri exist
        if (!headers_sent() && isset($_SERVER["HTTP_REFERER"])) {
            // redirect to previous url
            header("location: {$_SERVER["HTTP_REFERER"]}", true, 302);
            exit;
        }
    }
}
