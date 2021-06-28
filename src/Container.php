<?php

namespace Zeretei\PHPCore;

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
    protected $registry = [];

    /**
     * Bind value to container
     * 
     * @param string $key
     * @param mixed $value
     */
    public function bind($key, $value)
    {
        // bind a value to container
        $this->registry[$key] = $value;
    }

    /**
     * Get value from container
     * 
     * @param string
     */
    public function get($key)
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
