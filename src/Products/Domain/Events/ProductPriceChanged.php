<?php

namespace Mathieudegracia\ArchiEventBus\Products\Domain\Events;

use Mathieudegracia\ArchiEventBus\Shared\Event\DomainEvent;

final class ProductPriceChanged extends DomainEvent
{
    public function __construct(
        public readonly string $productId,
        public readonly float  $newPrice,
        public readonly string $currency,
    ) {
        parent::__construct();
    }
}