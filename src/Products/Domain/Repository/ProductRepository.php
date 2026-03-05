<?php

namespace Mathieudegracia\ArchiEventBus\Products\Domain\Repository;

use Mathieudegracia\ArchiEventBus\Products\Domain\Product;

interface ProductRepository
{
    public function findById(string $id): Product;

    public function save(Product $product): void;
}
