# Testing Strategy

> PHPUnit setup, factories, fixtures, mocking, integration tests, CI pipeline.

## PHPUnit Configuration

```xml
<!-- phpunit.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
         failOnRisky="true"
         failOnWarning="true">
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory>src</directory>
        </include>
    </source>
</phpunit>
```

## Test Base Class

```php
// tests/TestCase.php
abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app): array
    {
        return [
            GsmuiProServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }
}
```

## Model Factories

```php
// database/factories/ProductFactory.php
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'sku' => strtoupper($this->faker->bothify('???-#####')),
            'price' => $this->faker->numberBetween(100, 100000),
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['draft', 'active', 'archived']),
            'category_id' => Category::factory(),
            'vendor_id' => User::factory(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['status' => 'active']);
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => 'draft']);
    }

    public function withCategory(int $categoryId): static
    {
        return $this->state(fn () => ['category_id' => $categoryId]);
    }

    public function priced(int $cents): static
    {
        return $this->state(fn () => ['price' => $cents]);
    }
}

// Usage
$product = Product::factory()->create();
$products = Product::factory()->count(10)->active()->create();
$product = Product::factory()->draft()->priced(5000)->create();
```

## Unit Tests

```php
// tests/Unit/Models/ProductTest.php
class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_has_sku(): void
    {
        $product = Product::factory()->create(['sku' => 'WGT-001']);

        $this->assertEquals('WGT-001', $product->sku);
    }

    public function test_product_price_is_formatted(): void
    {
        $product = Product::factory()->create(['price' => 2500]);

        $this->assertEquals('$25.00', $product->formatted_price);
    }

    public function test_product_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertNotNull($product->category);
        $this->assertEquals($category->id, $product->category->id);
    }
}

// tests/Unit/Services/ProductServiceTest.php
class ProductServiceTest extends TestCase
{
    protected ProductServiceInterface $service;
    protected MockInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(ProductRepositoryInterface::class);
        $this->service = new ProductService($this->repository);
    }

    public function test_create_calls_repository(): void
    {
        $data = ['name' => 'Widget', 'price' => 1000];
        $product = Product::make($data);

        $this->repository
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($product);

        $result = $this->service->create($data);

        $this->assertEquals($product, $result);
    }
}
```

## Feature Tests

```php
// tests/Feature/Http/Controllers/ProductControllerTest.php
class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_index_requires_auth(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_index_returns_products(): void
    {
        Product::factory()->count(5)->create();

        $response = $this->actingAs($this->user)
            ->get(route('products.index'));

        $response->assertOk();
        $response->assertViewHas('products');
    }

    public function test_store_creates_product(): void
    {
        $data = [
            'name' => 'Widget',
            'sku' => 'WGT-001',
            'price' => 2500,
            'category_id' => Category::factory()->create()->id,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('products.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('products', ['name' => 'Widget']);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('products.store'), []);

        $response->assertSessionHasErrors(['name', 'sku', 'price']);
    }
}
```

## Mocking

```php
class SearchServiceTest extends TestCase
{
    public function test_search_returns_results(): void
    {
        $mock = Mockery::mock(MeilisearchClient::class);
        $mock->shouldReceive('index')
            ->once()
            ->with('products')
            ->andReturnSelf();
        $mock->shouldReceive('search')
            ->once()
            ->with('widget', Mockery::type('array'))
            ->andReturn(['hits' => [], 'nbHits' => 0]);

        $this->app->instance(MeilisearchClient::class, $mock);

        $service = app(SearchServiceInterface::class);
        $results = $service->search('widget');

        $this->assertEmpty($results->hits);
    }

    public function test_notification_is_sent(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        // Trigger notification
        event(new UserVerifiedEmail($user));

        Notification::assertSentTo($user, WelcomeNotification::class);
    }
}
```

## Database Assertions

```php
class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_creation(): void
    {
        Product::factory()->create([
            'name' => 'Test Product',
            'sku' => 'TST-001',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'sku' => 'TST-001',
        ]);

        $this->assertDatabaseCount('products', 1);
    }

    public function test_product_deletion(): void
    {
        $product = Product::factory()->create();

        $product->delete();

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    }
}
```

## CI Pipeline

```yaml
# .github/workflows/tests.yml
name: Tests

on:
  push:
    branches: [main]
  pull_request:
    branches: [main]

jobs:
  test:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: testing
        ports:
          - 3306:3306

      redis:
        image: redis:7
        ports:
          - 6379:6379

    steps:
      - uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: dom, curl, libxml, mbstring, zip
          coverage: xdebug

      - name: Install dependencies
        run: composer install --no-progress --prefer-dist

      - name: Run tests
        run: vendor/bin/phpunit --coverage-clover=coverage.xml

      - name: Upload coverage
        uses: codecov/codecov-action@v3
        with:
          files: coverage.xml
```

## Test Coverage

| Area | Tool | Target |
|---|---|---|
| Unit tests | PHPUnit | 90%+ |
| Feature tests | PHPUnit | 80%+ |
| Browser tests | Playwright | Critical paths |
| Code coverage | Xdebug | 85%+ overall |
| Mutation | Infection | >70% MSI |
