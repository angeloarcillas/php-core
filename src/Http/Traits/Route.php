<?php

namespace Zeretei\PHPCore\Http\Traits;

use Zeretei\PHPCore\Application;

trait Route
{
    /**
     * Load routes file
     * 
     * @param string $file
     */
    public function load(string $file)
    {
        $routes = require_once $file;
        $routes(Application::getInstance()->get('router'));
    }

    /**
     * Get request
     * 
     * @param string $url
     * @param array|callable $controller
     */
    public function get(string $url, array|callable $controller): void
    {
        $this->addRoute('GET', $url, $controller);
    }

    /**
     * Post request
     * 
     * @param string $url
     * @param array|callable $controller
     */
    public function post(string $url, array|callable $controller): void
    {
        $this->addRoute('POST', $url, $controller);
    }
}
