<?php

namespace Mathieudegracia\ArchiEventBus\Shared\Event;

use Mathieudegracia\ArchiEventBus\Shared\Event\DomainEvent;
use Mathieudegracia\ArchiEventBus\Shared\Event\EventListener;
use Mathieudegracia\ArchiEventBus\Shared\Event\EventBus;

class InMemoryEventBus implements EventBus
{
    /** @var array<string, EventListener[]> */
    private array $listeners = [];

    public function subscribe(EventListener $listener): void
    {
        $eventClass = $listener->supports();

        $this->listeners[$eventClass][] = $listener;
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {

            $eventClass = get_class($event);

            foreach ($this->listeners[$eventClass] ?? [] as $listener) {
                $listener->handle($event);
            }
        }
    }
}
