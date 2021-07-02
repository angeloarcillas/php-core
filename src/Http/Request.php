<?php

namespace Zeretei\PHPCore\Http;

use \Zeretei\PHPCore\Http\Traits\Validator;

class Request
{
    use Validator;

    /**
     * attributes placeholder
     */
    protected array $attributes = [];

    public function __construct()
    {
        // sanitze request
        $this->attributes = array_map(function (string $request) {
            if (!is_string($request)) return $request;
            $filter = filter_var($request, FILTER_SANITIZE_STRING);
            $xhtml = htmlspecialchars($filter);
            return strip_tags($xhtml);
        }, $_REQUEST);
    }

    /**
     * Request URI
     */
    public static function uri(): string
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $filter = filter_var($url, FILTER_SANITIZE_URL);
        return parse_url($filter, PHP_URL_PATH);
    }

    /**
     * Request method
     */
    public static function method(): string
    {
        $method = filter_var($_SERVER['REQUEST_METHOD'], FILTER_SANITIZE_STRING);
        return strtoupper($method);
    }

    /**
     * Request query string
     */
    public static function query(string $key = null): mixed
    {
        if (is_null($key)) return $_GET;

        return $_GET[$key] ?? null;
    }

    /**
     * Set Request attributes
     */
    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get Request attribute
     */
    public function __get(string $key): mixed
    {
        if (!array_key_exists($key, $this->attributes)) {
            throw new \Exception(
                sprintf("Property %s doesn't exists on class %s.", $key, __CLASS__)
            );
        }

        return $this->attributes[$key];
    }

    /**
     * Get a request based on request method
     */
    public static function request($key)
    {
        if (static::method() === 'POST') {
            return $_POST[$key] ?? null;
        }

        if (static::method() === 'GET') {
            return $_GET[$key] ?? null;
        }

        return null;
    }

    /**
     * Return all attributes
     */
    public function all(): array
    {
        return $this->attributes;
    }

    /**
     * Get request client IP
     */
    public static function ip()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}
