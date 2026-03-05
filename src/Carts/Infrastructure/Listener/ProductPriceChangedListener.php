<?php

namespace Mathieudegracia\ArchiEventBus\Carts\Infrastructure\Listener;

use Mathieudegracia\ArchiEventBus\Carts\Domain\Repository\CartItemRepository;
use Mathieudegracia\ArchiEventBus\Products\Domain\Events\ProductPriceChanged;
use Mathieudegracia\ArchiEventBus\Shared\Event\DomainEvent;
use Mathieudegracia\ArchiEventBus\Shared\Event\EventListener;

class ProductPriceChangedListener implements EventListener
{
    public function __construct(
        private CartItemRepository $cartItemRepository,
    ) {}

    public function supports(): string
    {
        return ProductPriceChanged::class;
    }

    public function handle(DomainEvent $event): void
    {
        assert($event instanceof ProductPriceChanged);

        $this->cartItemRepository->updatePrice(
            productId: $event->productId,
            newPrice: $event->newPrice,
        );
    }
}