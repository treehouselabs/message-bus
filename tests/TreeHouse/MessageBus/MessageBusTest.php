<?php

namespace Tests\TreeHouse\MessageBus;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use stdClass;
use PHPUnit_Framework_TestCase;
use TreeHouse\MessageBus\MessageBus;
use TreeHouse\MessageBus\Middleware\MiddlewareInterface;

class MessageBusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MiddlewareInterface|ObjectProphecy
     */
    protected $middleware;

    /**
     * @var MessageBus
     */
    protected $messageBus;

    public function setUp()
    {
        $this->messageBus = new MessageBus();
        $this->middleware = $this->prophesize(MiddlewareInterface::class);
    }

    /**
     * @test
     */
    public function it_registers_middlewares()
    {
        $middleware = $this->middleware->reveal();
    
        $this->messageBus->registerMiddleware($middleware);

        $this->assertEquals(true, $this->messageBus->hasMiddleware($middleware));
    }

    /**
     * @test
     */
    public function it_handles_middleware()
    {
        $message = new stdClass();

        $this->middleware->handle(
            $message,
            Argument::any()
        )->shouldBeCalled();

        $this->messageBus->registerMiddleware(
            $this->middleware->reveal()
        );

        $this->messageBus->handle(
            new stdClass()
        );
    }
}
