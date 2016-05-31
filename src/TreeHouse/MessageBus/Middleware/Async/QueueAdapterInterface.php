<?php

namespace TreeHouse\MessageBus\Middleware\Async;

interface QueueAdapterInterface
{
    public function publish($message);
}
