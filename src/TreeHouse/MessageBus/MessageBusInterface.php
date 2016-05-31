<?php

namespace TreeHouse\MessageBus;

interface MessageBusInterface
{
    /**
     * @param mixed $message
     */
    public function handle($message);
}
