<?php

namespace Mathieudegracia\ArchiEventBus\Products\Application\UseCase;

use Mathieudegracia\ArchiEventBus\Products\Domain\Repository\ProductRepository;
use Mathieudegracia\ArchiEventBus\Shared\Event\EventBus;

class ChangePriceUseCase
{
    public function __construct(
        private ProductRepository $repository,
        private EventBus $bus,
    ) {}

    public function execute(string $productId, float $newPrice): void
    {
        $product = $this->repository->findById($productId);

        $product->changePrice($newPrice);

        $this->repository->save($product);

        $this->bus->publish(... $product->pullEvents());
    }
}
