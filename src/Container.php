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
    protected static ?Container $instance = null;

    /**
     * data placeholder
     * 
     *  @var array
     */
    protected array $registry = [];

    /**
     * Bind value to container
     * 
     * @param string $key
     * @param mixed $value
     */
    public function bind(string $key, mixed $value): void
    {
        // bind a value to container
        $this->registry[$key] = $value;
    }

    /**
     * Get value from container
     * 
     * @param string
     * @return mixed 
     */
    public function get(string $key): mixed
    {
        // check if value exist on contaienr
        if (!array_key_exists($key, $this->registry)) {
            throw new \Exception("No {$key} is bound in the container.");
        }

        // return value from container
        return $this->registry[$key];
    }

    /**
     * Get the instance of the Container
     */
    public static function getInstance(): Container
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
