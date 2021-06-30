<?php

namespace Zeretei\PHPCore\Blueprint;

/**
 * Controller base class
 */
abstract class Controller
{

    /**
     * Current router controller action executed
     */
    protected string $action;

    /**
     * @var \Zeretei\PHPCore\Blueprint\Middleware
     */
    protected array $middlewares = [];

    /**
     * magic method to call undefined method
     */
    public function __call($method, $parameters)
    {
        // thorw error since method does not exists
        throw new \Exception(sprintf(
            'Method: "%s()" does not exists on %s.',
            $method,
            static::class
        ));
    }

    protected function registerMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Set router controller action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * Return all registered middlewares
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
