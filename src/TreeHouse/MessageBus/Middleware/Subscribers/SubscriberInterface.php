<?php

namespace TreeHouse\MessageBus\Middleware\Subscribers;

interface SubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents();
}
