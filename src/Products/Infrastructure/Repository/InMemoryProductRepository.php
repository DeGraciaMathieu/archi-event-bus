<?php

namespace Mathieudegracia\ArchiEventBus\Products\Infrastructure\Repository;

use Mathieudegracia\ArchiEventBus\Products\Domain\Product;
use Mathieudegracia\ArchiEventBus\Products\Domain\Repository\ProductRepository;

class InMemoryProductRepository implements ProductRepository
{
    public function findById(string $id): Product
    {
        return new Product(
            id: $id,
            name: 'Product ' . $id,
            price: 100,
            currency: 'EUR',
        );
    }
    
    public function save(Product $product): void
    {
        echo "[Products] Product saved: {$product->getId()}"
            . " → {$product->getName()} ({$product->getPrice()} {$product->getCurrency()})\n";
    }
}