<?php

namespace Zeretei\PHPCore;

use \Zeretei\PHPCore\Container;
use \Zeretei\PHPCore\Http\Router;
use \Zeretei\PHPCore\Http\Request;
use \Zeretei\PHPCore\Http\Response;

/**
 * Application base class
 */
class Application
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
     * @param array $config
     */
    public function __construct(array $config = null)
    {
        $this->ROOT_DIR = $config['root_dir'] ?? '/';
        Container::bind('config', $config);
        $this->registerServices();
        $this->registerPath();
    }

    /**
     * Run application
     */
    public function run()
    {
        try {
            // start output buffer
            ob_start();

            // start router
            Container::get('router')->resolve();
            
            // echo output buffer
            echo ob_get_clean();
        } catch (\Exception $e) {
            ddd($e);
        }
    }

    /**
     * Register services to container
     */
    protected function registerServices()
    {
        Container::bind('app', $this);
        Container::bind('router', new Router());
        Container::bind('request', new Request());
        Container::bind('response', new Response());
    }

    /**
     * Register paths tp container
     */
    protected function registerPath()
    {
        Container::bind('path.views', $this->ROOT_DIR . '/app/Views');
        Container::bind('path.controllers', $this->ROOT_DIR . '/app/Controllers');
        Container::bind('path.models', $this->ROOT_DIR . '/app/Models');
    }
}
