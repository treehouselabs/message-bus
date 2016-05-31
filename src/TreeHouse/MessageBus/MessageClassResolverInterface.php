<?php

namespace TreeHouse\MessageBus;

interface MessageClassResolverInterface
{
    /**
     * @param string $messageName
     *
     * @return string message class
     */
    public function resolve($messageName);
}
