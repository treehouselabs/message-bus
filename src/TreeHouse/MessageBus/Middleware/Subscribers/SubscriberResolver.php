<?php

namespace TreeHouse\MessageBus\Middleware\Subscribers;

use TreeHouse\MessageBus\MessageNameResolverInterface;

class SubscriberResolver implements SubscriberResolverInterface
{
    /**
     * @var callable[]
     */
    protected $mapping = [];

    /**
     * @var MessageNameResolverInterface
     */
    protected $messageNameResolver;

    /**
     * SubscriberResolver constructor.
     *
     * @param MessageNameResolverInterface $messageNameResolver
     */
    public function __construct(MessageNameResolverInterface $messageNameResolver)
    {
        $this->messageNameResolver = $messageNameResolver;
    }

    /**
     * @param SubscriberInterface $subscriber
     */
    public function registerSubscriber(SubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $messageName => $method) {
            if (!isset($this->mapping[$messageName])) {
                $this->mapping[$messageName] = [];
            }

            $this->mapping[$messageName][] = [&$subscriber, $method];
        }
    }

    /**
     * @param object $message
     *
     * @return callable[]
     */
    public function resolve($message)
    {
        $messageName = $this->messageNameResolver->resolve(
            $message->getEvent()
        );

        if (isset($this->mapping[$messageName])) {
            return $this->mapping[$messageName];
        }

        return [];
    }
}
