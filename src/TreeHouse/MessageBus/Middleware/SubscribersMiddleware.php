<?php

namespace TreeHouse\MessageBus\Middleware;

use TreeHouse\MessageBus\Middleware\Subscribers\SubscriberResolverInterface;

class SubscribersMiddleware implements MiddlewareInterface
{
    /**
     * @var SubscriberResolverInterface
     */
    protected $subscriberResolver;

    /**
     * SubscribersMiddleware constructor.
     *
     * @param SubscriberResolverInterface $subscriberResolver
     */
    public function __construct(SubscriberResolverInterface $subscriberResolver)
    {
        $this->subscriberResolver = $subscriberResolver;
    }

    /**
     * @param object $message
     * @param callable $next
     */
    public function handle($message, callable $next)
    {
        $subscribers = $this->subscriberResolver->resolve($message);

        foreach ($subscribers as $subscriber) {
            call_user_func_array($subscriber, [$message]);
        }

        $next($message);
    }
}
