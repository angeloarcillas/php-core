<?php

namespace Zeretei\PHPCore;

use \Zeretei\PHPCore\Http\{Router, Route, Request, Response};
use \Zeretei\PHPCore\Container;

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


    public function __construct($config = null)
    {
        $this->ROOT_DIR = $config['root_path'] ?? '/';
        $this->bind('config', $config);
        $this->bind('router', new Router());
        $this->bind('route', new Route());
        $this->bind('request', new Request());
        $this->bind('response', new Response());
    }

    /**
     * Run application
     */
    public function run()
    {
        try {
            $this->get('route')->resolve();
        } catch (\Exception $e) {
            ddd($e);
        }
    }
}
