<?php

namespace Zeretei\PHPCore;

use Zeretei\PHPCore\Router;

class Application
{
    /**
     * Application version
     * 
     * @var VERSION string
     */
    public const VERSION = '0.1.0';

    /** 
     * @var $router \Zeretei\PHPCore\Router
     */
    protected static Router $router;


    /**
     * Initialize application
     */
    public static function init()
    {
        // create a router instance
        static::$router = Router::getInstance();
    }

    /**
     * Run application
     */
    public static function run()
    {
        try {
            static::$router->resolve();
        } catch (\Exception $e) {
            ddd($e);
        }
    }
}
