<?php

namespace Tests\TreeHouse\MessageBus;

class SerializableTestMessage
{
    /**
     * @var string
     */
    protected $foo;

    /**
     * @param string $foo
     */
    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'foo' => $this->foo,
        ];
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public static function deserialize($data)
    {
        $self = new self($data['foo']);

        return $self;
    }
}
