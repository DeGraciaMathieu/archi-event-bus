<?php

namespace Mathieudegracia\ArchiEventBus\Carts\Domain\Repository;

interface CartItemRepository
{
    public function updatePrice(string $productId, float $newPrice): void;
}
