<?php


/**
 * Service Container
 */
class App
{
    public static $instance;
    public static $registry = [];

    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    public function get($key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new \Exception("No {$key} is bound in the container.");
        }

        return static::$registry[$key];
    }

    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }


    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        // $exists = isset($this->attributes[$key]);

        // if (!$exists) {
        //     throw new Exception("Property {$key} doesn't exists on class " . __CLASS__);
        // }
        return $this->data[$key];
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }
}
