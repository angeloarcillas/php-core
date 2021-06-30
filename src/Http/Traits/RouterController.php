<?php

namespace Zeretei\PHPCore\Http\Traits;

/**
 * TODO:
 * 1. Catch current method executed
 * 2. Add authorization
 */
trait RouterController
{
    /**
     * Available wildcard regex pattern
     * 
     * @var array
     */
    protected array $patterns = [
        ":int" => "(\d+)",
        ":char" => "([a-zA-Z]+)",
        ":str" => "(\w+)",
        ":any" => "(.+)",
    ];

    /**
     * Get all routes with wildcard
     * 
     * @param array $routes
     * @return array
     */
    protected function getRoutesWithWildcard(array $routes): array
    {
        // callback to filter wildcard routes
        $hasWildcard = fn ($_v, $route) => str_contains($route, ':');
        // filter routes w/ wildcard then return
        return array_filter($routes, $hasWildcard, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Match request url with wildcard route
     * 
     * @param string $route
     * @param string $url
     * @return bool
     */
    protected function matchWildcard(string $route, string $url): bool
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
            $this->attributes = array_slice($values, 1);
            return true;
        }

        return false;
    }

    /**
     * Call matched controller action
     * 
     * @param array $controller
     * @return mixed
     */
    protected function callAction(array $controller): mixed
    {
        // check if class exists
        if (!class_exists($controller[0])) {
            throw new \Exception(
                sprintf('Controller: "%s" does not exists.', $controller[0])
            );
        }

        // set $controller and $action
        [$controller, $action] = [...$controller, null];

        // create a class instance
        $class = new $controller();

        // check if $action is null
        if (is_null($action)) {
            // call invoke method
            return $this->callInvoke($class);
        }
        $class->setAction($action);


        foreach ($class->getMiddlewares() as $middleware) {
            $middleware->execute($action);
        }
        // call action w/ params
        return $class->$action(...$this->attributes);
    }

    /**
     * Call invoke magic method
     * 
     * @param object $class
     * @return mixed
     */
    protected function callInvoke(object $class): mixed
    {
        // check if __invoke magic method exists
        if (!is_callable($class)) {
            throw new \Exception(
                sprintf('Method: "__invoke" does not exists on %s.', $class::class)
            );
        }

        // call __invoke method
        return $class();
    }
}
