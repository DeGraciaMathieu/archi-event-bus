<?php

require_once __DIR__ . '/vendor/autoload.php';

use Mathieudegracia\ArchiEventBus\Carts\Infrastructure\Listener\ProductPriceChangedListener;
use Mathieudegracia\ArchiEventBus\Carts\Infrastructure\Repository\InMemoryCartItemRepository;
use Mathieudegracia\ArchiEventBus\Products\Application\UseCase\ChangePriceUseCase;
use Mathieudegracia\ArchiEventBus\Products\Infrastructure\Repository\InMemoryProductRepository;
use Mathieudegracia\ArchiEventBus\Shared\Event\InMemoryEventBus;

$bus = new InMemoryEventBus();

$bus->subscribe(new ProductPriceChangedListener(
    cartItemRepository: new InMemoryCartItemRepository(),
));

$changePriceUseCase = new ChangePriceUseCase(
    new InMemoryProductRepository(), 
    $bus,
);

$changePriceUseCase->execute('1', 100);
