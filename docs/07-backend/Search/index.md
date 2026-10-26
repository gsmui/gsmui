# Search Implementation

> Meilisearch index jobs, search filters, faceted search, real-time indexing.

## Meilisearch Setup

```php
// config/meilisearch.php
return [
    'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
    'key' => env('MEILISEARCH_KEY'),
    'index_settings' => [
        'products' => [
            'searchableAttributes' => ['name', 'sku', 'description', 'category_name'],
            'filterableAttributes' => ['status', 'category_id', 'price', 'vendor_id'],
            'sortableAttributes' => ['price', 'created_at', 'name'],
            'rankingRules' => [
                'words',
                'typo',
                'proximity',
                'attribute',
                'sort',
                'exactness',
            ],
        ],
    ],
];
```

## Index Jobs

```php
// app/Jobs/SearchIndex/RebuildProductIndexJob
class RebuildProductIndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly ?string $modelClass = null
    ) {}

    public function handle(): void
    {
        $class = $this->modelClass ?? Product::class;

        $index = $class::meilisearchIndex();

        $index->deleteAllDocuments();

        $class::query()
            ->with(['category', 'vendor'])
            ->chunk(500, function ($products) use ($index) {
                $documents = $products->map(fn ($product) => $this->toSearchableArray($product))->toArray();
                $index->addDocuments($documents);
            });
    }

    protected function toSearchableArray(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'description' => $product->description,
            'price' => $product->price,
            'status' => $product->status,
            'category_id' => $product->category_id,
            'category_name' => $product->category?->name,
            'vendor_id' => $product->vendor_id,
            'created_at' => $product->created_at->timestamp,
        ];
    }
}

// app/Jobs/SearchIndex/UpdateProductIndexJob
class UpdateProductIndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Product $product
    ) {}

    public function handle(): void
    {
        $index = Product::meilisearchIndex();

        $index->updateDocuments([
            $this->toSearchableArray($this->product),
        ]);
    }

    public function failed(Throwable $exception): void
    {
        Log::error("Failed to index product {$this->product->id}: {$exception->getMessage()}");
    }
}
```

## Model Traits

```php
// app/Traits/Searchable.php
trait Searchable
{
    public static function bootSearchable(): void
    {
        static::created(function (Model $model) {
            dispatch(new UpdateProductIndexJob($model));
        });

        static::updated(function (Model $model) {
            dispatch(new UpdateProductIndexJob($model));
        });

        static::deleted(function (Model $model) {
            $index = static::meilisearchIndex();
            $index->deleteDocument($model->getKey());
        });
    }

    public static function meilisearchIndex()
    {
        return Meilisearch::index(static::searchIndexName());
    }

    public static function searchIndexName(): string
    {
        return strtolower(class_basename(static::class)) . 's';
    }
}

// app/Models/Product.php
class Product extends Model
{
    use Searchable;

    protected $searchable = ['name', 'sku', 'description'];
    protected $filterable = ['status', 'category_id', 'price', 'vendor_id'];
    protected $sortable = ['price', 'created_at', 'name'];
}
```

## Search Filters

```php
class ProductSearchService
{
    public function search(string $query, array $filters = []): SearchResult
    {
        $index = Product::meilisearchIndex();

        $searchOptions = [
            'limit' => $filters['per_page'] ?? 15,
            'offset' => (($filters['page'] ?? 1) - 1) * ($filters['per_page'] ?? 15),
        ];

        // Apply filters
        if (!empty($filters['status'])) {
            $searchOptions['filter'] = "status = '{$filters['status']}'";
        }

        if (!empty($filters['category_id'])) {
            $searchOptions['filter'][] = "category_id = {$filters['category_id']}";
        }

        if (!empty($filters['min_price'])) {
            $searchOptions['filter'][] = "price >= {$filters['min_price']}";
        }

        if (!empty($filters['max_price'])) {
            $searchOptions['filter'][] = "price <= {$filters['max_price']}";
        }

        // Apply sorting
        if (!empty($filters['sort'])) {
            $direction = $filters['sort_direction'] ?? 'asc';
            $searchOptions['sort'] = ["{$filters['sort']}:{$direction}"];
        }

        $results = $index->search($query, $searchOptions);

        return new SearchResult(
            hits: $results['hits'],
            totalHits: $results['nbHits'],
            page: $filters['page'] ?? 1,
            perPage: $filters['per_page'] ?? 15,
            processingTime: $results['processingTimeMs'],
        );
    }
}
```

## Faceted Search

```php
class FacetedSearchService
{
    public function searchWithFacets(string $query, array $filters = []): FacetedResult
    {
        $index = Product::meilisearchIndex();

        $results = $index->search($query, [
            'facets' => ['category_name', 'status', 'vendor_name'],
            'filter' => $this->buildFilterString($filters),
        ]);

        return new FacetedResult(
            hits: $results['hits'],
            facets: $results['facets'],
            totalHits: $results['nbHits'],
        );
    }

    protected function buildFilterString(array $filters): string
    {
        $conditions = [];

        foreach ($filters as $key => $value) {
            if (is_array($value)) {
                $conditions[] = collect($value)
                    ->map(fn ($v) => "{$key} = '{$v}'")
                    ->implode(' OR ');
            } else {
                $conditions[] = "{$key} = '{$value}'";
            }
        }

        return implode(' AND ', $conditions);
    }
}

// Blade template
// <div class="facets">
//     @foreach($facets['category_name'] as $category => $count)
//         <label>
//             <input type="checkbox" name="category[]" value="{{ $category }}">
//             {{ $category }} ({{ $count }})
//         </label>
//     @endforeach
// </div>
```

## Real-Time Indexing

```php
// app/Listeners/ProductSearchListener
class ProductSearchListener
{
    public function handleProductCreated(ProductCreated $event): void
    {
        dispatch(new UpdateProductIndexJob($event->product));
    }

    public function handleProductUpdated(ProductUpdated $event): void
    {
        dispatch(new UpdateProductIndexJob($event->product));
    }

    public function handleProductDeleted(ProductDeleted $event): void
    {
        $index = Product::meilisearchIndex();
        $index->deleteDocument($event->product->id);
    }
}

// EventServiceProvider
protected $listen = [
    ProductCreated::class => [ProductSearchListener::class],
    ProductUpdated::class => [ProductSearchListener::class],
    ProductDeleted::class => [ProductSearchListener::class],
];
```

## Search Result DTO

```php
readonly class SearchResult
{
    public function __construct(
        public array $hits,
        public int $totalHits,
        public int $page,
        public int $perPage,
        public int $processingTime,
    ) {}

    public function totalPages(): int
    {
        return (int) ceil($this->totalHits / $this->perPage);
    }

    public function toArray(): array
    {
        return [
            'data' => $this->hits,
            'meta' => [
                'total_hits' => $this->totalHits,
                'page' => $this->page,
                'per_page' => $this->perPage,
                'total_pages' => $this->totalPages(),
                'processing_time_ms' => $this->processingTime,
            ],
        ];
    }
}

readonly class FacetedResult extends SearchResult
{
    public function __construct(
        array $hits,
        public array $facets,
        int $totalHits,
    ) {
        parent::__construct($hits, $totalHits, 1, 15, 0);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'facets' => $this->facets,
        ]);
    }
}
```

## Search Testing

```php
class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['meilisearch.host' => env('MEILISEARCH_HOST')]);
    }

    public function test_product_is_indexed_on_creation(): void
    {
        $product = Product::factory()->create(['name' => 'Red Widget']);

        $index = Product::meilisearchIndex();
        $results = $index->search('Widget');

        $this->assertNotEmpty($results['hits']);
        $this->assertEquals($product->id, $results['hits'][0]['id']);
    }

    public function test_search_returns_filtered_results(): void
    {
        Product::factory()->create(['status' => 'active']);
        Product::factory()->create(['status' => 'archived']);

        $results = (new ProductSearchService())->search('', [
            'status' => 'active',
        ]);

        $this->assertCount(1, $results->hits);
    }
}
```

## Search Performance

| Metric | Target | Notes |
|---|---|---|
| Response time | < 50ms | Meilisearch default |
| Index rebuild | < 30s | 10k products |
| Real-time sync | < 500ms | Event to index |
| Memory usage | < 256MB | 50k documents |
