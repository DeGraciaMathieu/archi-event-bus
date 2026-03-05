<?php

namespace Mathieudegracia\ArchiEventBus\Carts\Infrastructure\Repository;

use Mathieudegracia\ArchiEventBus\Carts\Domain\Repository\CartItemRepository;

class InMemoryCartItemRepository implements CartItemRepository
{
    public function updatePrice(string $productId, float $newPrice): void
    {
        echo "[Carts] Price updated for product {$productId}"
            . " → {$newPrice}\n";
    }
}
