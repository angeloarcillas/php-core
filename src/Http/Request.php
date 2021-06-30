<?php

namespace Zeretei\PHPCore\Http;

/**
 * TODO:
 * 1. Improve security
 * 2. add request validation
 */
class Request
{
    /**
     * attributes placeholder
     * 
     * @var array $attributes
     */
    protected array $attributes = [];

    public function __construct()
    {
        // set attriutes and sanitize request
        $this->attributes = array_map(function (string $request) {
            // check if it's not a string
            if (!is_string($request)) return $request;

            // convert special character to html entities
            $xhtml = htmlspecialchars($request);

            // strip html and php tags
            return strip_tags($xhtml);
        }, $_REQUEST);
    }

    /**
     * Request URI
     */
    public static function uri(): string
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
    public static function method(): string
    {
        // forced uppercase HTTP method
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Request query string
     * 
     * @param string $key
     * @return mixed
     */
    public static function query(string $key = null): mixed
    {
        // if key is null, return all get request
        if (is_null($key)) return $_GET;

        // return specific get request
        return $_GET[$key] ?? null;
    }

    /**
     * Set Request attributes
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get Request attribute
     * 
     * @param string $key
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        // check if $key exists on Request attributes
        if (!array_key_exists($key, $this->attributes)) {
            throw new \Exception("Property {$key} doesn't exists on class " . __CLASS__);
        }

        return $this->attributes[$key];
    }

    public function all()
    {
        return $this->attributes;
    }
}
