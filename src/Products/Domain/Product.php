<?php

namespace Mathieudegracia\ArchiEventBus\Products\Domain;

use Mathieudegracia\ArchiEventBus\Products\Domain\Events\ProductPriceChanged;

class Product
{
    private array $domainEvents = [];

    public function __construct(
        private string $id,
        private string $name,
        private float  $price,
        private string $currency = 'EUR',
    ) {}

    public function changePrice(float $newPrice): void
    {
        $this->price = $newPrice;

        $this->domainEvents[] = new ProductPriceChanged(
            productId: $this->id,
            newPrice: $newPrice,
            currency: $this->currency,
        );
    }

    public function pullEvents(): array
    {
        $events = $this->domainEvents;

        $this->domainEvents = [];

        return $events;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
