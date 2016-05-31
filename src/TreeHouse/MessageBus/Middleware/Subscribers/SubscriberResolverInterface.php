<?php

namespace TreeHouse\MessageBus\Middleware\Subscribers;

interface SubscriberResolverInterface
{
    /**
     * @param object $message
     *
     * @return callable[]
     */
    public function resolve($message);
}
