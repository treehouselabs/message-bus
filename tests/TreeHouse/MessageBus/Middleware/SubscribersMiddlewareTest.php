<?php

namespace Tests\TreeHouse\MessageBus\Middleware;

use TreeHouse\MessageBus\Middleware\Subscribers\SubscriberResolverInterface;
use TreeHouse\MessageBus\Middleware\SubscribersMiddleware;

class SubscribersMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_calls_next()
    {
        /** @var SubscriberResolverInterface $subscriberResolver */
        $subscriberResolver = $this->prophesize(SubscriberResolverInterface::class);

        $nextIsCalled = false;

        $message = new \stdClass();
        $next = function() use (&$nextIsCalled) { $nextIsCalled = true; };

        $subscriberResolver->resolve($message)->willReturn([]);

        $middleware = new SubscribersMiddleware(
            $subscriberResolver->reveal()
        );

        $middleware->handle($message, $next);

        $this->assertEquals(true, $nextIsCalled, 'Next should be called');
    }

    /**
     * @test
     */
    public function it_calls_subscribers()
    {
        /** @var SubscriberResolverInterface $subscriberResolver */
        $subscriberResolver = $this->prophesize(SubscriberResolverInterface::class);

        $message = new \stdClass();
        $next = function() {};

        $subscriber = $this->prophesize(TestSubscriber::class);
        $subscriber->handle($message)->shouldBeCalled();

        $subscriberResolver->resolve($message)->willReturn([[$subscriber, 'handle']]);

        $middleware = new SubscribersMiddleware(
            $subscriberResolver->reveal()
        );

        $middleware->handle($message, $next);
    }
}
