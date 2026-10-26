# Repositories

> Repository pattern: interface contracts, Eloquent implementations, query scopes, caching.

## Interface Contracts

Every model gets a repository interface defining its data access surface:

```php
// App/Contracts/ProductRepositoryInterface
interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;

    public function findBySku(string $sku): ?Product;

    public function create(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function delete(Product $product): bool;

    public function search(string $query, array $filters = []): Collection;

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
}
```

## Eloquent Implementation

```php
// App/Repositories/EloquentProductRepository
class EloquentProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        protected Product $model
    ) {}

    public function findById(int $id): ?Product
    {
        return $this->model->newQuery()->find($id);
    }

    public function findBySku(string $sku): ?Product
    {
        return $this->model->newQuery()
            ->where('sku', $sku)
            ->first();
    }

    public function create(array $data): Product
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->fresh();
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function search(string $query, array $filters = []): Collection
    {
        return $this->model->newQuery()
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->applyFilters($filters)
            ->get();
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->applyFilters($filters)
            ->latest()
            ->paginate($perPage);
    }
}
```

## Query Scopes

```php
// app/Models/Product.php
class Product extends Model
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeInCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopePriceBetween(Builder $query, int $min, int $max): Builder
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeApplyFilters(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['status'] ?? null, fn ($q, $s) => $q->where('status', $s))
            ->when($filters['category_id'] ?? null, fn ($q, $c) => $q->where('category_id', $c))
            ->when($filters['min_price'] ?? null, fn ($q, $p) => $q->where('price', '>=', $p))
            ->when($filters['max_price'] ?? null, fn ($q, $p) => $q->where('price', '<=', $p));
    }
}
```

## Repository Binding

```php
class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, function ($app) {
            return new EloquentProductRepository(new Product());
        });

        $this->app->bind(OrderRepositoryInterface::class, function ($app) {
            return new EloquentOrderRepository(new Order());
        });

        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return new EloquentUserRepository(new User());
        });
    }
}
```

## Caching Layer

```php
class CachedProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        protected ProductRepositoryInterface $repository,
        protected CacheService $cache,
    ) {}

    public function findById(int $id): ?Product
    {
        return $this->cache->remember(
            "products.{$id}",
            3600,
            fn () => $this->repository->findById($id)
        );
    }

    public function create(array $data): Product
    {
        $product = $this->repository->create($data);
        $this->cache->forget("products.all");
        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $updated = $this->repository->update($product, $data);
        $this->cache->forget("products.{$product->id}");
        return $updated;
    }

    public function delete(Product $product): bool
    {
        $deleted = $this->repository->delete($product);
        $this->cache->forget("products.{$product->id}");
        return $deleted;
    }
}
```

## Repository Testing

```php
class EloquentProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ProductRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentProductRepository(new Product());
    }

    public function test_find_by_id_returns_product(): void
    {
        $product = Product::factory()->create(['id' => 42]);

        $result = $this->repository->findById(42);

        $this->assertNotNull($result);
        $this->assertEquals(42, $result->id);
    }

    public function test_find_by_sku_returns_null_for_missing(): void
    {
        $result = $this->repository->findBySku('NONEXISTENT');

        $this->assertNull($result);
    }

    public function test_search_finds_matching_products(): void
    {
        Product::factory()->create(['name' => 'Red Widget']);
        Product::factory()->create(['name' => 'Blue Widget']);
        Product::factory()->create(['name' => 'Green Gear']);

        $results = $this->repository->search('Widget');

        $this->assertCount(2, $results);
    }
}
```

## Repository Variants

| Type | Use Case | Features |
|---|---|---|
| `Eloquent` | Standard ORM access | Scopes, relationships |
| `Cached` | Read-heavy models | Redis/file caching |
| `Search` | Full-text search | Meilisearch/Algolia |
| `ReadOnly` | Projections/reports | No write methods |
| `Bulk` | Batch operations | Insert/update/delete |

## Repository vs Query Builder

| Aspect | Repository | Query Builder |
|---|---|---|
| Abstraction | High | Low |
| Testability | Mockable | Harder |
| Consistency | Interface contract | Ad-hoc |
| Performance | Same | Same |
| Overhead | Minimal | None |
