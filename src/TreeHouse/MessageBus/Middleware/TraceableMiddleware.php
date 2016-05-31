<?php

namespace TreeHouse\MessageBus\Middleware;

class TraceableMiddleware implements MiddlewareInterface
{
    protected $tracedMessages = [];

    /**
     * @param object $message
     * @param callable $next
     */
    public function handle($message, callable $next)
    {
        $this->tracedMessages[] = $message;

        $next($message);
    }

    /**
     * @return array
     */
    public function getTracedMessages()
    {
        return $this->tracedMessages;
    }

    public function clearTracedMessages()
    {
        $this->tracedMessages = [];
    }
}
