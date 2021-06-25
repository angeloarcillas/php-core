<?php

namespace Zeretei\PHPCore\Http;

class Request
{
    /**
     * attributes placeholder
     * 
     * @var array $attributes
     */
    protected $attributes = [];

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

    public function __get($key)
    {
        if (!array_key_exists($key, $this->attributes)) {
            throw new \Exception("Property {$key} doesn't exists on class " . __CLASS__);
        }

        return $this->attributes[$key];
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }
}
