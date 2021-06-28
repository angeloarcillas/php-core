<?php

namespace Zeretei\PHPCore\Http;

trait Route
{
    /**
     * Load routes file
     * 
     * @param string $file
     */
    public static function load($file)
    {
        return require $file;
    }

    /**
     * Get request
     * 
     * @param string $url
     * @param array|callable $controller
     */
    public static function get($url, $controller)
    {
        static::addRoute('GET', $url, $controller);
    }

    /**
     * Post request
     * 
     * @param string $url
     * @param array|callable $controller
     */
    public static function post($url, $controller)
    {
        static::addRoute('POST', $url, $controller);
    }
}
