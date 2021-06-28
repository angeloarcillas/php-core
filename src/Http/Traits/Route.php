<?php

namespace Zeretei\PHPCore\Http\Traits;

trait Route
{
    /**
     * Load routes file
     * 
     * @param string $file
     */
    public static function load(string $file)
    {
        return require $file;
    }

    /**
     * Get request
     * 
     * @param string $url
     * @param array|callable $controller
     */
    public static function get(string $url, array|callable $controller): void
    {
        static::addRoute('GET', $url, $controller);
    }

    /**
     * Post request
     * 
     * @param string $url
     * @param array|callable $controller
     */
    public static function post(string $url, array|callable $controller): void
    {
        static::addRoute('POST', $url, $controller);
    }
}
