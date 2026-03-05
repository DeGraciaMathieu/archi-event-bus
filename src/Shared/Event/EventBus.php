<?php

namespace Mathieudegracia\ArchiEventBus\Shared\Event;

use Mathieudegracia\ArchiEventBus\Shared\Event\DomainEvent;
use Mathieudegracia\ArchiEventBus\Shared\Event\EventListener;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
    public function subscribe(EventListener $listener): void;
}
