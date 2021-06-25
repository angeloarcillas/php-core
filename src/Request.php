<?php

namespace Zeretei\PHPCore;

class Request
{
    public static function uri()
    {
        // trimmed url
        $url = trim($_SERVER['REQUEST_URI'], '/');
        // url w/out query string
        $base_url = parse_url($url, PHP_URL_PATH);
        return $base_url;
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
