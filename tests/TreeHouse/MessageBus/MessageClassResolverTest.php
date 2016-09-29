<?php

namespace Tests\TreeHouse\MessageBus;

use TreeHouse\MessageBus\MessageClassResolver;

class MessageClassResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_registers_classes()
    {
        $resolver = new MessageClassResolver([]);

        $resolver->registerClass('SerializableTestMessage', SerializableTestMessage::class);

        $this->assertEquals(SerializableTestMessage::class, $resolver->resolve('SerializableTestMessage'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_cannot_register_duplicate_messages()
    {
        $resolver = new MessageClassResolver([]);

        $resolver->registerClass('SerializableTestMessage', SerializableTestMessage::class);
        $resolver->registerClass('SerializableTestMessage', SerializableTestMessage::class);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function it_unregisters_classes()
    {
        $resolver = new MessageClassResolver([]);

        $resolver->registerClass('SerializableTestMessage', SerializableTestMessage::class);
        $resolver->unregisterClass('SerializableTestMessage');

        $this->assertEquals(SerializableTestMessage::class, $resolver->resolve('SerializableTestMessage'));
    }
}
