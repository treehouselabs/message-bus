<?php

namespace TreeHouse\MessageBus;

use TreeHouse\MessageBus\Middleware\MiddlewareInterface;

class MessageBus implements MessageBusInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    protected $middlewares = [];

    /**
     * MessageBus constructor.
     *
     * @param MiddlewareInterface $middleware
     */
    public function registerMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @param MiddlewareInterface $middleware
     *
     * @return bool
     */
    public function hasMiddleware(MiddlewareInterface $middleware)
    {
        return in_array($middleware, $this->middlewares, true);
    }

    /**
     * @param object $message
     */
    public function handle($message)
    {
        $next = function($message) {};

        $middlewares = array_reverse($this->middlewares);

        foreach ($middlewares as $middleware) {
            $next = function ($message) use ($middleware, $next) {
                $middleware->handle($message, $next);
            };
        }

        $next($message);
    }
}
