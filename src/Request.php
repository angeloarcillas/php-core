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
}
