# Actions

> Single-action pattern: focused controllers, action classes, bus dispatching.

## Action Pattern

Actions encapsulate a single business operation with clear input/output:

```php
// app/Actions/Products/CreateProductAction
class CreateProductAction
{
    public function __construct(
        protected ProductRepository $products,
        protected EventDispatcher $events,
    ) {}

    public function execute(CreateProductDTO $dto): Product
    {
        $product = $this->products->create([
            'name' => $dto->name,
            'sku' => $dto->sku,
            'price' => $dto->price,
            'description' => $dto->description,
        ]);

        $this->events->dispatch(new ProductCreated($product));

        return $product;
    }
}
```

## Single-Action Controllers

```php
// app/Http/Controllers/Products/StoreProductController
class StoreProductController extends Controller
{
    public function __invoke(StoreProductRequest $request): RedirectResponse
    {
        $product = app(CreateProductAction::class)->execute(
            CreateProductDTO::fromRequest($request)
        );

        return redirect()->route('products.show', $product)
            ->with('success', 'Product created.');
    }
}

// Route definition
Route::post('/products', StoreProductController::class)->name('products.store');
```

## Action Variants

| Type | Input | Output | Use Case |
|---|---|---|---|
| `CreateAction` | DTO | Model | Resource creation |
| `UpdateAction` | Model + DTO | Model | Resource update |
| `DeleteAction` | Model | bool | Soft/hard delete |
| `ProcessAction` | Mixed | Mixed | Complex workflows |

```php
class UpdateProductAction
{
    public function execute(Product $product, UpdateProductDTO $dto): Product
    {
        $product->update($dto->toArray());

        ProductUpdated::dispatch($product);

        return $product;
    }
}

class DeleteProductAction
{
    public function execute(Product $product): bool
    {
        $deleted = $product->delete();

        ProductDeleted::dispatch($product);

        return $deleted;
    }
}
```

## Bus Dispatching

```php
// Simple dispatch
$product = dispatch(new CreateProductAction($dto));

// Synchronous dispatch (wait for result)
$product = dispatch_sync(new CreateProductAction($dto));

// Chained dispatch
dispatch(new CreateProductAction($dto))
    ->chain([
        new SendProductNotification($product),
        new UpdateSearchIndex($product),
    ]);
```

## Form Requests as Action Inputs

```php
class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'unique:products,sku'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', Product::class);
    }
}

class StoreProductController extends Controller
{
    public function __invoke(StoreProductRequest $request): Product
    {
        return app(CreateProductAction::class)->execute(
            CreateProductDTO::fromRequest($request)
        );
    }
}
```

## Action Pipelines

```php
class ProcessOrderAction
{
    public function execute(CreateOrderDTO $dto): Order
    {
        return app(Pipeline::class)
            ->send($dto)
            ->through([
                ValidateInventory::class,
                CalculatePricing::class,
                ApplyDiscounts::class,
                ReserveStock::class,
            ])
            ->then(fn ($dto) => $this->createOrder($dto));
    }
}

class ValidateInventory
{
    public function handle(CreateOrderDTO $dto, Closure $next): CreateOrderDTO
    {
        foreach ($dto->items as $item) {
            if (!$this->hasStock($item)) {
                throw new InsufficientStockException($item);
            }
        }

        return $next($dto);
    }
}
```

## Action Testing

```php
class CreateProductActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_product_and_dispatches_event(): void
    {
        $events = Event::fake();

        $dto = new CreateProductDTO(
            name: 'Widget',
            sku: 'WGT-001',
            price: 2500,
            description: 'A fine widget',
        );

        $product = app(CreateProductAction::class)->execute($dto);

        $this->assertDatabaseHas('products', [
            'name' => 'Widget',
            'sku' => 'WGT-001',
            'price' => 2500,
        ]);

        $events->assertDispatched(ProductCreated::class, function ($event) use ($product) {
            return $event->product->id === $product->id;
        });
    }

    public function test_throws_on_duplicate_sku(): void
    {
        Product::factory()->create(['sku' => 'WGT-001']);

        $dto = new CreateProductDTO(
            name: 'Widget',
            sku: 'WGT-001',
            price: 2500,
        );

        $this->expectException(\Illuminate\Database\QueryException::class);

        app(CreateProductAction::class)->execute($dto);
    }
}
```

## Action Organization

```
app/Actions/
├── Products/
│   ├── CreateProductAction.php
│   ├── UpdateProductAction.php
│   ├── DeleteProductAction.php
│   └── SearchProductsAction.php
├── Orders/
│   ├── PlaceOrderAction.php
│   ├── CancelOrderAction.php
│   └── ProcessRefundAction.php
└── Users/
    ├── RegisterUserAction.php
    ├── VerifyEmailAction.php
    └── DeactivateUserAction.php
```

## Action vs Controller Decision

| Criteria | Action | Controller |
|---|---|---|
| Single operation | Yes | No |
| Reusable across routes | Yes | No |
| Complex business logic | Yes | No |
| Simple CRUD | No | Yes |
| Needs Form Request | Either | Either |
