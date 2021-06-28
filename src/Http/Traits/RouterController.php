<?php

namespace Zeretei\PHPCore\Http\Traits;

trait RouterController
{
    /**
     * Available wildcard regex pattern
     * 
     * @var array
     */
    protected $patterns = [
        ":int" => "(\d+)",
        ":char" => "([a-zA-Z]+)",
        ":str" => "(\w+)",
        ":any" => "(.+)",
    ];

    protected function getRoutesWithWildcard($routes)
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
            $this->attributes = array_slice($values, 1);
            return true;
        }

        return false;
    }


    protected function callAction($controller)
    {
        if (!class_exists($controller[0])) {
            throw new \Exception(
                sprintf('Controller: "%s" does not exists.', $controller[0])
            );
        }

        [$controller, $action] = [...$controller, null];

        $class = new $controller();

        if (is_null($action)) {
            return $this->callInvoke($class);
        }

        return $class->$action(...$this->attributes);
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
