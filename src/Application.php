<?php

namespace Zeretei\PHPCore;

use \Zeretei\PHPCore\Container;
use \Zeretei\PHPCore\Http\Router;
use \Zeretei\PHPCore\Http\Request;
use \Zeretei\PHPCore\Http\Response;

/**
 * Application base class
 */
class Application extends Container
{
    /**
     * Application version
     * 
     * @var string
     */
    public const VERSION = '0.1.0';

    /**
     * Application root directory
     * 
     * @var string
     */
    public const ROOT_DIR = '/';


    /**
     * Bind default application configs
     * 
     * @param null|string $config
     */
    public function __construct($config = null)
    {
        $this->ROOT_DIR = $config['root_path'] ?? '/';
        $this->bind('config', $config);
        $this->bind('router', new Router());
        $this->bind('request', new Request());
        $this->bind('response', new Response());
    }

    /**
     * Run application
     */
    public function run()
    {
        try {
            $this->get('router')->resolve();
        } catch (\Exception $e) {
            ddd($e);
        }
    }
}
