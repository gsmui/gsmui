# Modules

> Modular architecture for Marketable, Documentable, Billable, and Authenticatable domains.

## Module Structure

Each module encapsulates its own routes, views, migrations, and services:

```
app/Modules/
├── Marketable/
│   ├── Contracts/
│   │   └── MarketableInterface.php
│   ├── Models/
│   │   └── Product.php
│   ├── Services/
│   │   └── ProductService.php
│   ├── Actions/
│   │   └── CreateProductAction.php
│   ├── Routes/
│   │   └── web.php
│   ├── Views/
│   │   └── products/
│   └── Migrations/
│       └── 2026_01_01_create_products_table.php
├── Documentable/
├── Billable/
└── Authenticatable/
```

## Module Interface

```php
interface ModuleInterface
{
    public function name(): string;

    public function register(): void;

    public function boot(): void;

    public function routes(): void;

    public function migrations(): array;

    public function views(): string;

    public function permissions(): array;
}
```

## Module Registration

```php
class MarketableModule implements ModuleInterface
{
    public function name(): string
    {
        return 'marketable';
    }

    public function register(): void
    {
        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService(
                $app->make(ProductRepository::class)
            );
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'marketable');
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        $this->registerRoutes();
    }

    public function routes(): void
    {
        Route::middleware(['web', 'auth'])
            ->prefix('products')
            ->group(__DIR__.'/Routes/web.php');
    }
}
```

## Module Manager

```php
class ModuleManager
{
    protected array $modules = [];

    protected Application $app;

    public function register(string $moduleClass): void
    {
        $module = new $moduleClass($this->app);
        $this->modules[$module->name()] = $module;
        $module->register();
    }

    public function boot(): void
    {
        foreach ($this->modules as $module) {
            $module->boot();
        }
    }

    public function get(string $name): ModuleInterface
    {
        return $this->modules[$name]
            ?? throw new \RuntimeException("Module [{$name}] not registered.");
    }

    public function all(): array
    {
        return $this->modules;
    }
}
```

## Marketable Module

| Component | Purpose |
|---|---|
| `ProductService` | CRUD, pricing, inventory |
| `ProductRepository` | Query product data |
| `CreateProductAction` | Validated creation |
| `ProductPolicy` | Authorization |

```php
class ProductService
{
    public function __construct(
        protected ProductRepository $products
    ) {}

    public function create(array $data): Product
    {
        return app(CreateProductAction::class)->execute($data);
    }

    public function bySku(string $sku): ?Product
    {
        return $this->products->findBySku($sku);
    }
}
```

## Documentable Module

```php
class DocumentService
{
    public function generate(string $type, Model $model): Document
    {
        return match($type) {
            'invoice' => app(GenerateInvoice::class)->execute($model),
            'quote'   => app(GenerateQuote::class)->execute($model),
            default   => throw new \InvalidArgumentException("Unknown document type: {$type}"),
        };
    }

    public function attachToModel(Model $model, Document $document): void
    {
        $model->documents()->attach($document->id);
    }
}
```

## Billable Module

```php
class BillableModule implements ModuleInterface
{
    public function register(): void
    {
        $this->app->singleton(BillingService::class, function ($app) {
            return new BillingService(
                $app->make(PaymentGateway::class),
                $app->make(InvoiceRepository::class)
            );
        });
    }
}

class BillingService
{
    public function charge(Model $billable, int $amount, array $meta = []): Transaction
    {
        $transaction = $this->gateway->charge($billable, $amount, $meta);

        ChargeCompleted::dispatch($transaction);

        return $transaction;
    }

    public function refund(Transaction $transaction, ?int $amount = null): Refund
    {
        return $this->gateway->refund($transaction, $amount);
    }
}
```

## Authenticatable Module

```php
class AuthenticatableModule implements ModuleInterface
{
    public function register(): void
    {
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService(
                $app->make(UserRepository::class),
                $app->make('auth')->guard()
            );
        });
    }

    public function permissions(): array
    {
        return [
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'roles.manage',
        ];
    }
}
```

## Module Discovery

```php
// config/modules.php
return [
    'modules' => [
        \App\Modules\Marketable\MarketableModule::class,
        \App\Modules\Documentable\DocumentableModule::class,
        \App\Modules\Billable\BillableModule::class,
        \App\Modules\Authenticatable\AuthenticatableModule::class,
    ],
];

// In ModuleServiceProvider
public function boot(): void
{
    $manager = $this->app->make(ModuleManager::class);

    foreach (config('modules.modules') as $moduleClass) {
        $manager->register($moduleClass);
    }

    $manager->boot();
}
```

## Cross-Module Communication

```php
// Events dispatched between modules
OrderPlaced::dispatch($order); // Billable module
// Listened by Documentable module
class GenerateOrderInvoice
{
    public function handle(OrderPlaced $event): void
    {
        app(DocumentService::class)->generate('invoice', $event->order);
    }
}
```
