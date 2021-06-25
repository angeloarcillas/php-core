<?php

namespace Zeretei\PHPCore;

class Container
{
    /**
     * @var self $instance
     */
    public static $instance;

    /**
     *  @var array $registry
     */
    public static $registry = [];

    /**
     * Bind value to container
     * 
     * @param string $key
     * @param mixed $value
     */
    public static function bind($key, $value)
    {
        // bind a value to container
        static::$registry[$key] = $value;
    }

    /**
     * Get value from container
     * 
     * @param string
     */
    public static function get($key)
    {
        // check if value exist on contaienr
        if (!array_key_exists($key, static::$registry)) {
            throw new \Exception("No {$key} is bound in the container.");
        }

        // return value from container
        return static::$registry[$key];
    }

    /**
     * Get the instance of the Container
     */
    public static function getInstance()
    {
        // check if instance is null
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        // return instance
        return static::$instance;
    }
}
