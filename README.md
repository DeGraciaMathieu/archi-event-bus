# Event Bus PHP Architecture

A pure PHP implementation of an Event Bus, demonstrating decoupled communication between Bounded Contexts via domain events.

## Concept

The Event Bus allows independent modules to communicate without knowing each other directly. One context publishes an event, another receives it with no coupling between the two.

## Quick Demo

```bash
composer install
php run.php
```

```php
$bus = new InMemoryEventBus();

$bus->subscribe(new ProductPriceChangedListener(
    cartItemRepository: new InMemoryCartItemRepository(),
));

$changePriceUseCase = new ChangePriceUseCase(
    new InMemoryProductRepository(),
    $bus,
);

$changePriceUseCase->execute('1', 100);
```

## Architecture

```
src/
├── Shared/Event/
│   ├── DomainEvent.php        # Abstract base class (eventId, occurredAt)
│   ├── EventBus.php           # Interface: publish/subscribe
│   ├── EventListener.php      # Interface: handle/supports
│   └── InMemoryEventBus.php   # In-memory implementation
│
├── Products/
│   ├── Domain/
│   │   ├── Product.php                    # Aggregate — emits events
│   │   ├── Events/ProductPriceChanged.php # Domain event
│   │   └── Repository/ProductRepository.php
│   ├── Application/UseCase/
│   │   └── ChangePriceUseCase.php         # Orchestrates business logic
│   └── Infrastructure/Repository/
│       └── InMemoryProductRepository.php
│
└── Carts/
    ├── Domain/Repository/CartItemRepository.php
    └── Infrastructure/
        ├── Listener/ProductPriceChangedListener.php  # Reacts to the event
        └── Repository/InMemoryCartItemRepository.php
```

## Diagrams

### Components

```mermaid
graph LR
    subgraph Products["Products Context"]
        UC[ChangePriceUseCase]
        AG[Product]
        PPE[ProductPriceChanged]
    end

    subgraph Shared["Shared"]
        EB[EventBus]
    end

    subgraph Carts["Carts Context"]
        LT[ProductPriceChangedListener]
        CR[CartItemRepository]
    end

    UC -->|"publish(ProductPriceChanged)"| EB
    EB -->|"handle(event)"| LT
    LT --> CR
    AG --> PPE
    UC --> AG
```

### Classes

```mermaid
classDiagram
    namespace Shared {
        class DomainEvent {
            <<abstract>>
            +string eventId
            +string occurredAt
            +__construct()
        }
        class EventBus {
            <<interface>>
            +publish(DomainEvent events) void
            +subscribe(EventListener listener) void
        }
        class EventListener {
            <<interface>>
            +handle(DomainEvent event) void
            +supports() string
        }
        class InMemoryEventBus {
            -array listeners
            +subscribe(EventListener listener) void
            +publish(DomainEvent events) void
        }
    }

    namespace Products {
        class Product {
            -string id
            -string name
            -float price
            -string currency
            -array domainEvents
            +changePrice(float newPrice) void
            +pullEvents() array
            +getId() string
            +getPrice() float
        }
        class ProductPriceChanged {
            +string productId
            +float newPrice
            +string currency
        }
        class ProductRepository {
            <<interface>>
            +findById(string id) Product
            +save(Product product) void
        }
        class InMemoryProductRepository {
            +findById(string id) Product
            +save(Product product) void
        }
        class ChangePriceUseCase {
            -ProductRepository repository
            -EventBus bus
            +execute(string productId, float newPrice) void
        }
    }

    namespace Carts {
        class CartItemRepository {
            <<interface>>
            +updatePrice(string productId, float newPrice) void
        }
        class InMemoryCartItemRepository {
            +updatePrice(string productId, float newPrice) void
        }
        class ProductPriceChangedListener {
            -CartItemRepository cartItemRepository
            +supports() string
            +handle(DomainEvent event) void
        }
    }

    DomainEvent <|-- ProductPriceChanged
    EventBus <|.. InMemoryEventBus
    EventListener <|.. ProductPriceChangedListener
    ProductRepository <|.. InMemoryProductRepository
    CartItemRepository <|.. InMemoryCartItemRepository
    ChangePriceUseCase --> ProductRepository
    ChangePriceUseCase --> EventBus
    InMemoryEventBus --> EventListener
    Product --> ProductPriceChanged
    ProductPriceChangedListener --> CartItemRepository
```
