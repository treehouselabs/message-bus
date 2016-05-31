<?php

namespace Tests\TreeHouse\MessageBus\Middleware;

use TreeHouse\MessageBus\Middleware\Async\QueueAdapterInterface;
use TreeHouse\MessageBus\Middleware\AsyncMiddleware;

class AsyncMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_calls_publish_on_adapter()
    {
        $message = new \stdClass();

        $adapter = $this->prophesize(QueueAdapterInterface::class);
        $adapter->publish($message)->shouldBeCalled();

        $middleware = new AsyncMiddleware($adapter->reveal());
        $middleware->handle($message, function() {});
    }

    /**
     * @test
     */
    public function it_should_not_call_next()
    {
        $nextIsNotCalled = true;

        $message = new \stdClass();
        $next = function() use (&$nextIsNotCalled) { $nextIsNotCalled = false; };

        $adapter = $this->prophesize(QueueAdapterInterface::class);

        $middleware = new AsyncMiddleware(
            $adapter->reveal()
        );

        $middleware->handle($message, $next);

        $this->assertEquals(true, $nextIsNotCalled, 'Next should not be called');
    }
}
