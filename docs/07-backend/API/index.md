# API Layer

> Resource controllers, API resources, rate limiting, authentication, versioning, documentation.

## Resource Controllers

```php
// app/Http/Controllers/Api/ProductController.php
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->search, fn ($q, $s) =>
                $q->where('name', 'LIKE', "%{$s}%")
            )
            ->when($request->category, fn ($q, $c) =>
                $q->where('category_id', $c)
            )
            ->paginate($request->per_page ?? 15);

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load(['category', 'vendor']));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return new ProductResource($product->fresh());
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
```

## API Resources

```php
// app/Http/Resources/ProductResource
class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->price,
            'status' => $this->status,
            'description' => $this->description,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'vendor' => new VendorResource($this->whenLoaded('vendor')),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }

    public function with($request): array
    {
        return [
            'meta' => [
                'api_version' => 'v1',
                'timestamp' => now()->toISOString(),
            ],
        ];
    }
}
```

## Rate Limiting

```php
// app/Providers/RouteServiceProvider.php
class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });
    }
}

// Usage in routes
Route::middleware('throttle:api')->group(function () {
    Route::apiResource('products', ProductController::class);
});

// Custom throttle response
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)
        ->by($request->user()?->id ?: $request->ip())
        ->response(fn () => response()->json([
            'error' => 'Too many requests',
            'retry_after' => 60,
        ], 429));
});
```

## Authentication

```php
// Route groups
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);
});

// Token abilities
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tokens', function () {
        $token = auth()->user()->createToken('api-token', ['products:read', 'orders:read']);
        return ['token' => $token->plainTextToken];
    });
});
```

## API Versioning

```php
// routes/api.php
Route::prefix('v1')->group(function () {
    Route::apiResource('products', ProductController::class);
});

Route::prefix('v2')->group(function () {
    Route::apiResource('products', V2\ProductController::class);
});

// Version via Accept header
Route::middleware('api.version:v1')->group(function () {
    Route::apiResource('products', ProductController::class);
});

// Middleware
class ApiVersionMiddleware
{
    public function handle(Request $request, Closure $next, string $version)
    {
        $request->attributes->set('api_version', $version);

        return $next($request);
    }
}
```

## API Documentation

```yaml
# openapi.yaml (excerpt)
openapi: 3.0.0
info:
  title: gsmui API
  version: 1.0.0

paths:
  /api/products:
    get:
      summary: List products
      tags: [Products]
      parameters:
        - name: search
          in: query
          schema:
            type: string
        - name: category
          in: query
          schema:
            type: integer
      responses:
        '200':
          description: Paginated product list
          content:
            application/json:
              schema:
                type: object
                properties:
                  data:
                    type: array
                    items:
                      $ref: '#/components/schemas/Product'
                  meta:
                    $ref: '#/components/schemas/PaginationMeta'
```

## Response Format

```php
class ApiResponse
{
    public static function success($data, int $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'timestamp' => now()->toISOString(),
            ],
        ], $code);
    }

    public static function error(string $message, int $code = 400, $errors = null)
    {
        return response()->json([
            'success' => false,
            'error' => $message,
            'errors' => $errors,
        ], $code);
    }
}
```

## API Testing

```php
class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_list_products(): void
    {
        Product::factory()->count(5)->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/products');

        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_can_create_product(): void
    {
        $data = ['name' => 'Widget', 'sku' => 'WGT-001', 'price' => 2500];

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/products', $data);

        $response->assertCreated()
            ->assertJsonFragment(['name' => 'Widget']);

        $this->assertDatabaseHas('products', $data);
    }

    public function test_unauthenticated_returns_401(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertUnauthorized();
    }

    public function test_rate_limiting_returns_429(): void
    {
        for ($i = 0; $i < 61; $i++) {
            $this->actingAs($this->user, 'sanctum')
                ->getJson('/api/products');
        }

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/products');

        $response->assertStatus(429);
    }
}
```

## Route Registration

```php
// routes/api.php
Route::prefix('api')
    ->middleware(['api', 'auth:sanctum'])
    ->group(function () {
        Route::apiResource('products', ProductController::class);
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('customers', CustomerController::class);

        // Custom endpoints
        Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel']);
        Route::get('/reports/sales', [ReportController::class, 'sales']);
    });
```
