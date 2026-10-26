# Services

> Service layer architecture: interfaces, dependency injection, lifecycle management.

## Interface Definitions

Every service has a contract to enable swapping and testing:

```php
// App\Contracts\ProductServiceInterface
interface ProductServiceInterface
{
    public function create(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function delete(Product $product): bool;

    public function findById(int $id): ?Product;

    public function search(string $query, array $filters = []): Collection;
}
```

```php
// App\Contracts\SearchServiceInterface
interface SearchServiceInterface
{
    public function index(Model $model): void;

    public function remove(Model $model): void;

    public function search(string $query, array $options = []): SearchResult;

    public function rebuildIndex(string $modelClass): void;
}
```

## Concrete Implementations

```php
class ProductService implements ProductServiceInterface
{
    public function __construct(
        protected ProductRepository $products,
        protected CacheService $cache,
        protected EventDispatcher $events,
    ) {}

    public function create(array $data): Product
    {
        $product = $this->products->create($data);

        $this->events->dispatch(new ProductCreated($product));

        $this->cache->forget("products.{$product->id}");

        return $product;
    }

    public function findById(int $id): ?Product
    {
        return $this->cache->remember(
            "products.{$id}",
            3600,
            fn () => $this->products->findById($id)
        );
    }
}
```

## Service Container Bindings

```php
class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

        $this->app->bind(SearchServiceInterface::class, function ($app) {
            if (config('services.search.driver') === 'meilisearch') {
                return new MeilisearchService($app->make(MeilisearchClient::class));
            }

            return new DatabaseSearchService($app->make(Builder::class));
        });
    }
}
```

## Lifecycle Management

| Lifecycle | Binding | Use Case |
|---|---|---|
| `bind` | New instance each call | Stateless helpers |
| `singleton` | One instance app-wide | Managers, config |
| `scoped` | One per request | Request-scoped services |

```php
// Request-scoped — reset between requests
$this->app->scoped(CartService::class, function ($app) {
    return new CartService(
        $app->make(CartRepository::class),
        $app->make(PricingEngine::class)
    );
});

// Conditional bindings
$this->app->bind(SearchServiceInterface::class, function ($app) {
    return $app->make(config('search.driver') === 'meilisearch'
        ? MeilisearchService::class
        : DatabaseSearchService::class
    );
});
```

## Service Composition

```php
class OrderService
{
    public function __construct(
        protected ProductServiceInterface $products,
        protected BillingServiceInterface $billing,
        protected InventoryServiceInterface $inventory,
        protected NotificationServiceInterface $notifications,
    ) {}

    public function placeOrder(CreateOrderDTO $dto): Order
    {
        return DB::transaction(function () use ($dto) {
            $order = $this->createOrder($dto);
            $this->inventory->reserve($order->items);
            $this->billing->charge($order);
            $this->notifications->orderPlaced($order);

            return $order;
        });
    }
}
```

## Facade Pattern for Services

```php
class ProductServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ProductServiceInterface::class;
    }
}

// Usage in controllers
class ProductController extends Controller
{
    public function store(StoreProductRequest $request)
    {
        $product = ProductServiceFacade::create($request->validated());

        return redirect()->route('products.show', $product);
    }
}
```

## Testing Services

```php
class ProductServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->products = Mockery::mock(ProductRepository::class);
        $this->cache = Mockery::mock(CacheService::class);
        $this->events = Mockery::mock(EventDispatcher::class);

        $this->service = new ProductService(
            $this->products,
            $this->cache,
            $this->events
        );
    }

    public function test_create_dispatches_event(): void
    {
        $data = ['name' => 'Widget', 'price' => 1000];
        $product = new Product($data);

        $this->products->shouldReceive('create')->once()->with($data)->andReturn($product);
        $this->events->shouldReceive('dispatch')->once()->with(Mockery::type(ProductCreated::class));
        $this->cache->shouldReceive('forget')->once();

        $result = $this->service->create($data);

        $this->assertEquals($product, $result);
    }

    public function test_find_by_id_uses_cache(): void
    {
        $product = new Product(['id' => 1]);

        $this->cache->shouldReceive('remember')
            ->once()
            ->with('products.1', 3600, Mockery::type('Closure'))
            ->andReturn($product);

        $result = $this->service->findById(1);

        $this->assertEquals($product, $result);
    }
}
```

## Service Naming Conventions

| Suffix | Purpose | Example |
|---|---|---|
| `Service` | Business logic | `ProductService` |
| `Repository` | Data access | `ProductRepository` |
| `Action` | Single operation | `CreateProductAction` |
| `Gateway` | External API | `StripeGateway` |
| `Engine` | Computation | `PricingEngine` |
| `Dispatcher` | Events/jobs | `EventDispatcher` |
