<?php

namespace Mathieudegracia\ArchiEventBus\Shared\Event;

use DateTimeImmutable;

abstract class DomainEvent
{
    public readonly string $eventId;
    public readonly string $occurredAt;

    public function __construct()
    {
        $this->eventId  = uniqid('evt_');
        $this->occurredAt = (new DateTimeImmutable())->format(DATE_ATOM);
    }
}
