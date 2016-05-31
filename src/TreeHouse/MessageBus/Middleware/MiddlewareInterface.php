<?php

namespace TreeHouse\MessageBus\Middleware;

interface MiddlewareInterface
{
    /**
     * @param object $message
     * @param callable $next
     */
    public function handle($message, callable $next);
}
