<?php

namespace Zeretei\PHPCore;

use \Zeretei\PHPCore\Container;

use \Zeretei\PHPCore\Http\Router;
use \Zeretei\PHPCore\Http\Request;
use \Zeretei\PHPCore\Http\Response;

use \Zeretei\PHPCore\Database\QueryBuilder;

use \Zeretei\PHPCore\Session;
use \Zeretei\PHPCore\Log;

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
     * Register all application default configs & services
     */
    public function __construct(array $config = null)
    {
        static::$instance = $this;
        $this->ROOT_DIR = $config['root_dir'] ?? '/';
        $this->registerServices($config);
        $this->registerPaths($config);
    }

    /**
     * Run application
     */
    public function run(string $uri, string $method)
    {
        try {
            // start routing
            ob_start();
            $this->get('router')->resolve($uri, $method);
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
     * Register services to the container
     */
    protected function registerServices(array $config)
    {
        $this->bind('app', $this);
        $this->bind('config', $config);

        $this->bind('router', new Router());
        $this->bind('request', new Request());
        $this->bind('response', new Response());

        $this->bind('database', new QueryBuilder($config['database']));

        $this->bind('session', new Session());
        $this->bind('log', new Log());
    }

    /**
     * Register paths to the container
     */
    protected function registerPaths(array $config)
    {
        $this->bind('path.routes', $config['path.routes'] ?? '/');
        $this->bind('path.databases', $config['path.databases'] ?? '/');
    }
}
