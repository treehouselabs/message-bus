<?php

namespace TreeHouse\MessageBus\Middleware;

use TreeHouse\MessageBus\Middleware\Async\QueueAdapterInterface;

class AsyncMiddleware implements MiddlewareInterface
{
    /**
     * @var QueueAdapterInterface
     */
    protected $queue;

    /**
     * AsyncMiddleware constructor.
     *
     * @param QueueAdapterInterface $queue
     */
    public function __construct(QueueAdapterInterface $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @param object $message
     * @param callable $next
     */
    public function handle($message, callable $next)
    {
        $this->queue->publish($message);

        // not calling $next here. This should be handled by a consumer.
    }
}
