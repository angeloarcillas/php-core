<?php

namespace Zeretei\PHPCore;

/**
 * Service cointainer for application
 */
class Container
{
    /**
     * Container instance
     * 
     * @var self
     */
    protected static $instance;

    /**
     * data placeholder
     * 
     *  @var array
     */
    protected static array $registry = [];

    /**
     * Bind value to container
     * 
     * @param string $key
     * @param mixed $value
     */
    public static function bind(string $key, mixed $value): void
    {
        // bind a value to container
        static::$registry[$key] = $value;
    }

    /**
     * Get value from container
     * 
     * @param string
     * @return mixed 
     */
    public static function get(string $key): mixed
    {
        // check if value exist on contaienr
        if (!array_key_exists($key, static::$registry)) {
            throw new \Exception("No {$key} is bound in the container.");
        }

        // return value from container
        return static::$registry[$key];
    }

    /**
     * All bind services
     */
    public static function all()
    {
        return static::$registry;
    }

    /**
     * Get the instance of the Container
     */
    public static function getInstance()
    {
        // check if instance is null
        if (is_null(static::$instance)) {
            // set instance
            static::$instance = new static;
        }

        // return instance
        return static::$instance;
    }
}
