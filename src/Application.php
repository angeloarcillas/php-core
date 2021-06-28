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

        Container::bind('application', $this);
        Container::bind('config', $config);
        Container::bind('router', new Router());
        Container::bind('request', new Request());
        Container::bind('response', new Response());
    }

    /**
     * Run application
     */
    public function run()
    {
        try {
            Container::get('router')->resolve();
        } catch (\Exception $e) {
            ddd($e);
        }
    }
}
