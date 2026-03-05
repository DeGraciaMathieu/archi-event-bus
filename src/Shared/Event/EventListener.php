<?php

namespace Mathieudegracia\ArchiEventBus\Shared\Event;

use Mathieudegracia\ArchiEventBus\Shared\Event\DomainEvent;

interface EventListener
{
    public function handle(DomainEvent $event): void;
    public function supports(): string;
}
