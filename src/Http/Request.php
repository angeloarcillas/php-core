<?php

namespace Zeretei\PHPCore\Http;

class Request
{
    /**
     * Request URI
     */
    public static function uri()
    {
        // trimmed url
        $url = trim($_SERVER['REQUEST_URI'], '/');
        // url w/out query string
        $base_url = parse_url($url, PHP_URL_PATH);
        return $base_url;
    }

    /**
     * Request method
     */
    public static function method()
    {
        // forced uppercase
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Request query string
     * 
     * @param null|string $key
     */
    public static function query($key = null)
    {
        // if key is null, return all get request
        if (is_null($key)) return $_GET;

        // return specific get request
        return $_GET[$key] ?? null;
    }
}
