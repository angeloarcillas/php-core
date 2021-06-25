<?php

namespace Zeretei\PHPCore;

use Zeretei\PHPCore\Http\Router;

class Application
{
    /**
     * Application version
     * 
     * @var string VERSION
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
