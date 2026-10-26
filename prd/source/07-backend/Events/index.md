# Events

> Domain events, listeners, subscribers, broadcasting, and event discovery.

## Domain Events

Events represent something that happened in the domain:

```php
// app/Events/ProductCreated
class ProductCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Product $product
    ) {}
}

// app/Events/OrderPlaced
class OrderPlaced
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Order $order,
        public readonly int $totalCents,
    ) {}
}

// app/Events/UserVerifiedEmail
class UserVerifiedEmail
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly User $user
    ) {}
}
```

## Listeners

```php
// app/Listeners/SendProductCreatedNotification
class SendProductCreatedNotification
{
    public function __construct(
        protected NotificationService $notifications
    ) {}

    public function handle(ProductCreated $event): void
    {
        $this->notifications->send(
            $event->product->vendor,
            new ProductCreatedNotification($event->product)
        );
    }
}

// app/Listeners/UpdateSearchIndex
class UpdateSearchIndex
{
    public function __construct(
        protected SearchService $search
    ) {}

    public function handle(ProductCreated $event): void
    {
        $this->search->index($event->product);
    }
}
```

## Event-Listener Registration

```php
// app/Providers/EventServiceProvider.php
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProductCreated::class => [
            SendProductCreatedNotification::class,
            UpdateSearchIndex::class,
            SyncProductInventory::class,
        ],
        OrderPlaced::class => [
            SendOrderConfirmation::class,
            DeductInventory::class,
            UpdateAnalytics::class,
        ],
        UserVerifiedEmail::class => [
            SendWelcomeEmail::class,
            AssignDefaultRole::class,
        ],
    ];
}
```

## Subscribers

```php
// app/Listeners/OrderEventSubscriber
class OrderEventSubscriber
{
    public function handleOrderPlaced(OrderPlaced $event): void
    {
        // Send confirmation
    }

    public function handleOrderCancelled(OrderCancelled $event): void
    {
        // Restore inventory
    }

    public function handleOrderRefunded(OrderRefunded $event): void
    {
        // Process refund
    }

    public function subscribe(Dispatcher $events): void
    {
        $events->listen(OrderPlaced::class, [self::class, 'handleOrderPlaced']);
        $events->listen(OrderCancelled::class, [self::class, 'handleOrderCancelled']);
        $events->listen(OrderRefunded::class, [self::class, 'handleOrderRefunded']);
    }
}

// Register in EventServiceProvider
protected $subscribe = [
    OrderEventSubscriber::class,
];
```

## Broadcasting Events

```php
// app/Events/OrderStatusUpdated
class OrderStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Broadcastable;

    public function __construct(
        public readonly Order $order
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('orders.' . $this->order->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'status.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
            'updated_at' => $this->order->updated_at->toISOString(),
        ];
    }
}

// Broadcast from listener
class BroadcastOrderStatus
{
    public function handle(OrderStatusUpdated $event): void
    {
        broadcast($event->toOthers());
    }
}
```

## Event Sourcing

```php
class ProductAggregate
{
    protected array $events = [];

    public function create(string $name, int $price): void
    {
        $this->record(new ProductWasCreated(
            id: Uuid::uuid4(),
            name: $name,
            price: $price,
        ));
    }

    public function updatePrice(int $newPrice): void
    {
        $this->record(new ProductPriceWasChanged(
            id: $this->id,
            oldPrice: $this->price,
            newPrice: $newPrice,
        ));
    }

    protected function record(object $event): void
    {
        $this->events[] = $event;
        $this->apply($event);
    }

    protected function apply(object $event): void
    {
        $handler = 'apply' . class_basename($event);

        if (method_exists($this, $handler)) {
            $this->{$handler}($event);
        }
    }

    protected function applyProductWasCreated(ProductWasCreated $event): void
    {
        $this->id = $event->id;
        $this->name = $event->name;
        $this->price = $event->price;
    }
}
```

## Event Discovery

Laravel auto-discovers events and listeners:

```php
// Enable in AppServiceProvider
public function boot(): void
{
    $this->app->booted(function () {
        Event::discoverEvents();
    });
}

// Configure in EventServiceProvider
protected $discoverEvents = [
    __DIR__.'/../Listeners/*Listener.php',
    __DIR__.'/../Listeners/*Subscriber.php',
];
```

## Event Testing

```php
class ProductCreatedTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_dispatched_on_product_creation(): void
    {
        Event::fake([ProductCreated::class]);

        Product::factory()->create();

        Event::assertDispatched(ProductCreated::class, function ($event) {
            return $event->product->exists;
        });
    }

    public function test_listener_sends_notification(): void
    {
        Notification::fake();

        $product = Product::factory()->create();

        event(new ProductCreated($product));

        Notification::assertSentTo(
            $product->vendor,
            ProductCreatedNotification::class
        );
    }
}
```

## Event Priority

```php
class EventServiceProvider
{
    protected $listen = [
        OrderPlaced::class => [
            ['SendOrderConfirmation::class', 10],  // High priority
            ['DeductInventory::class', 5],          // Medium priority
            ['UpdateAnalytics::class', 1],           // Low priority
        ],
    ];
}
```

## Wildcard Listeners

```php
// Listen to all events
Event::listen('*', function ($eventName, array $data) {
    Log::info("Event fired: {$eventName}");
});

// Pattern matching
Event::listen('Order*', function ($eventName, array $data) {
    Metrics::increment($eventName);
});
```
