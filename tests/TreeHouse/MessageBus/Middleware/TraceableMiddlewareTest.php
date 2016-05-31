<?php

namespace Tests\TreeHouse\MessageBus\Middleware;

use PHPUnit_Framework_TestCase;
use TreeHouse\MessageBus\Middleware\TraceableMiddleware;

class TraceableMiddlewareTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_calls_next()
    {
        $nextIsCalled = false;

        $message = new \stdClass();
        $next = function() use (&$nextIsCalled) { $nextIsCalled = true; };

        $middleware = new TraceableMiddleware();

        $middleware->handle($message, $next);

        $this->assertEquals(true, $nextIsCalled, 'Next should be called');
    }

    /**
     * @test
     */
    public function it_traces_messages()
    {
        $nextIsCalled = false;

        $message = new \stdClass();
        $next = function() use (&$nextIsCalled) { $nextIsCalled = true; };

        $middleware = new TraceableMiddleware();

        $middleware->handle($message, $next);

        $this->assertEquals([$message], $middleware->getTracedMessages());
    }
    
    /**
     * @test
     */
    public function it_clears_traced_messages()
    {
        $nextIsCalled = false;

        $message = new \stdClass();
        $next = function() use (&$nextIsCalled) { $nextIsCalled = true; };

        $middleware = new TraceableMiddleware();

        $middleware->handle($message, $next);
        
        $middleware->clearTracedMessages();

        $this->assertEquals([], $middleware->getTracedMessages());
    }
}
