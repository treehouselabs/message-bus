<?php

namespace TreeHouse\MessageBus;

interface MessageNameResolverInterface
{
    /**
     * @param object $message
     *
     * @return string
     */
    public function resolve($message);
}
