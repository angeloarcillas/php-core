<?php

namespace Zeretei\PHPCore;

use \Zeretei\PHPCore\Log;
use \Zeretei\PHPCore\Session;
use \Zeretei\PHPCore\Container;
use \Zeretei\PHPCore\Http\Router;
use \Zeretei\PHPCore\Http\Request;
use \Zeretei\PHPCore\Http\Response;
use \Zeretei\PHPCore\Database\QueryBuilder;

/**
 * TODO:
 * 1. Add events
 * 2. use proper exception w/ code
 * 
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
     *  @param array $config
     */
    public function __construct(array $config = null)
    {
        static::$instance = $this;
        $this->ROOT_DIR = $config['root_dir'] ?? '/';
        $this->registerServices($config);
        $this->registerPath();
    }

    /**
     * Run application
     */
    public function run($uri, $method)
    {
        try {
            // start output buffer
            ob_start();
            // start router
            $this->get('router')->resolve($uri, $method);

            // echo output buffer
            echo ob_get_clean();
        } catch (\Exception $e) {
            $error = sprintf(
                '[%s] %s  %s',
                $e->getCode(),
                $e->getFile() . PHP_EOL,
                $e->getMessage()
            );
            Log::set($error);
            ddd($e);
        }
    }

    /**
     * Register services to container
     */
    protected function registerServices($config)
    {
        $this->bind('app', $this);
        $this->bind('config', $config);
        $this->bind('router', new Router());
        $this->bind('request', new Request());
        $this->bind('response', new Response());
        $this->bind('session', new Session());
        $this->bind('log', new Log());
        $this->bind('database', new QueryBuilder($config['database']));
    }

    /**
     * Register paths tp container
     */
    protected function registerPath()
    {
        $this->bind('path.app', $this->ROOT_DIR . '/app');
        $this->bind('path.views', $this->ROOT_DIR . '/app/Views');
        $this->bind('path.models', $this->ROOT_DIR . '/app/Models');
        $this->bind('path.controllers', $this->ROOT_DIR . '/app/Controllers');
        $this->bind('path.database', $this->ROOT_DIR . '/app/Database');
    }
}
