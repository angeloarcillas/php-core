<?php

namespace Zeretei\PHPCore;

class Request
{
    public static function uri()
    {
        // sanitize url
        $url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        // remove query string
        $baseUrl = explode('?', $url)[0];
        // trim extra slashes then return url
        return trim($baseUrl, '/');
    }

    public static function method()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public static function query($key = null)
    {
        // if key is null, return all get request
        if (is_null($key)) return $_GET;

        // return specific get request
        return $_GET[$key] ?? null;
    }
}
