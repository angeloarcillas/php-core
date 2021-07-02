<?php

namespace Zeretei\PHPCore;

/**
 * Service cointainer for application 
 */
class Container
{
    /**
     * Container instance
     */
    protected static $instance;

    /**
     * services placeholder
     */
    protected static array $registry = [];

    /**
     * Register service to the container
     */
    public static function bind(string $key, mixed $value): void
    {
        static::$registry[$key] = $value;
    }

    /**
     * Get a service from the container
     */
    public static function get(string $key): mixed
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new \Exception(
                sprintf('No "%s" is registed in the container.', $key)
            );
        }

        return static::$registry[$key];
    }

    /**
     * All registed services
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
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }
}
