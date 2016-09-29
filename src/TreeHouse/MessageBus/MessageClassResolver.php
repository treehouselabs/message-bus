<?php

namespace TreeHouse\MessageBus;

class MessageClassResolver implements MessageClassResolverInterface
{
    /**
     * @var string[]
     */
    protected $classMap;
    
    /**
     * @param string[] $classMap
     */
    public function __construct(array $classMap = [])
    {
        $this->classMap = $classMap;
    }

    /**
     * @param string $messageName
     * @param string $messageClass
     */
    public function registerClass($messageName, $messageClass)
    {
        if (isset($this->classMap[$messageName])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Duplicate message name "%s" (`%s`) not allowed. Currently registered is `%s`',
                    $messageName,
                    $messageClass,
                    $this->classMap[$messageName]
                )
            );
        }

        $this->classMap[$messageName] = $messageClass;
    }

    /**
     * @param string $messageName
     */
    public function unregisterClass($messageName)
    {
        unset($this->classMap[$messageName]);
    }

    /**
     * @param string $messageName
     *
     * @return string class name of message/event
     */
    public function resolve($messageName)
    {
        if (!isset($this->classMap[$messageName])) {
            throw new \RuntimeException(
                sprintf(
                    'Could not resolve class for message %s. Did you forgot to register it?',
                    $messageName
                )
            );
        }

        return $this->classMap[$messageName];
    }
}