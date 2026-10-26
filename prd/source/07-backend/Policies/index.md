# Policies

> Authorization policies: registration, before/after methods, gate integration, testing.

## Policy Structure

```php
// app/Policies/ProductPolicy
class ProductPolicy
{
    /**
     * Run before any policy method.
     * Return true to grant access, false to deny, null to continue.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Run after all policy methods.
     */
    public function after(User $user, string $ability, ?Product $product): void
    {
        if ($ability === 'delete' && $product) {
            audit_log('policy.delete', $user, $product);
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('products.view');
    }

    public function view(User $user, Product $product): bool
    {
        return $user->hasPermissionTo('products.view')
            || $user->id === $product->vendor_id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('products.create');
    }

    public function update(User $user, Product $product): bool
    {
        return $user->hasPermissionTo('products.update')
            && $user->id === $product->vendor_id;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->hasPermissionTo('products.delete')
            && $user->id === $product->vendor_id
            && !$product->hasActiveOrders();
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->isSuperAdmin();
    }
}
```

## Policy Registration

```php
// app/Providers/AuthServiceProvider.php
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        User::class => UserPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
```

## Gate Definitions

```php
class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();

        // Define gates
        Gate::define('admin', function (User $user) {
            return $user->isSuperAdmin();
        });

        Gate::define('manage-users', function (User $user) {
            return $user->hasPermissionTo('users.manage');
        });

        Gate::define('access-dashboard', function (User $user) {
            return $user->hasAnyRole(['admin', 'manager']);
        });

        // Before/after callbacks
        Gate::before(function (User $user, string $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        Gate::after(function (User $user, string $ability, ?Model $model) {
            // Log all authorization attempts
        });

        // Deny with callback
        Gate::before(function (User $user) {
            if ($user->isBanned()) {
                return false;
            }
        });

        // Resource policy methods
        Gate::define('viewAny-Product', fn (User $user) => $user->hasPermissionTo('products.view'));
        Gate::define('view-Product', fn (User $user, Product $product) => $user->can('view', $product));
    }
}
```

## Controller Authorization

```php
class ProductController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Product::class);

        $products = Product::paginate();

        return view('products.index', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);

        $product = Product::create($request->validated());

        return redirect()->route('products.show', $product);
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);

        return view('products.show', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->update($request->validated());

        return redirect()->route('products.show', $product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('products.index');
    }
}
```

## Blade Authorization

```blade
@can('view', $product)
    <a href="{{ route('products.show', $product) }}">View</a>
@endcan

@can('update', $product)
    <form method="POST" action="{{ route('products.update', $product) }}">
        @method('PUT')
        @csrf
        <button type="submit">Update</button>
    </form>
@endcan

@can('delete', $product)
    <form method="POST" action="{{ route('products.destroy', $product) }}">
        @method('DELETE')
        @csrf
        <button type="submit">Delete</button>
    </form>
@endcan

@cannot('create', \App\Models\Product::class)
    <p>You don't have permission to create products.</p>
@endcannot
```

## Middleware Authorization

```php
// Route middleware
Route::middleware(['can:access-dashboard'])->group(function () {
    Route::get('/dashboard', DashboardController::class);
});

Route::middleware(['can:manage-users'])->group(function () {
    Route::get('/users', UserController::class);
});

// Resource controller middleware
Route::resource('products', ProductController::class)
    ->middleware(['can:viewAny,App\Models\Product'], 'index')
    ->middleware(['can:create,App\Models\Product'], 'create');
```

## Role-Based Policies

```php
class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return match(true) {
            $user->hasRole('admin') => true,
            $user->hasRole('manager') => true,
            $user->hasRole('customer') => true,
            default => false,
        };
    }

    public function view(User $user, Order $order): bool
    {
        return match(true) {
            $user->hasRole('admin') => true,
            $user->hasRole('manager') => $order->isInRegion($user->region),
            $user->hasRole('customer') => $user->id === $order->user_id,
            default => false,
        };
    }

    public function cancel(User $user, Order $order): bool
    {
        if ($order->status !== 'pending') {
            return false;
        }

        return match(true) {
            $user->hasRole('admin') => true,
            $user->hasRole('customer') => $user->id === $order->user_id,
            default => false,
        };
    }
}
```

## Testing Policies

```php
class ProductPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected ProductPolicy $policy;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new ProductPolicy();
        $this->user = User::factory()->create();
    }

    public function test_admin_can_do_anything(): void
    {
        $this->user->assignRole('admin');

        $product = Product::factory()->create();

        $this->assertTrue($this->policy->view($this->user, $product));
        $this->assertTrue($this->policy->update($this->user, $product));
        $this->assertTrue($this->policy->delete($this->user, $product));
    }

    public function test_customer_can_only_view_own_products(): void
    {
        $product = Product::factory()->create(['vendor_id' => $this->user->id]);
        $otherProduct = Product::factory()->create(['vendor_id' => 999]);

        $this->assertTrue($this->policy->view($this->user, $product));
        $this->assertFalse($this->policy->view($this->user, $otherProduct));
    }

    public function test_user_without_permission_cannot_create(): void
    {
        $this->assertFalse($this->policy->create($this->user));
    }

    public function test_before_grants_super_admin(): void
    {
        $this->user->is_super_admin = true;

        $result = $this->policy->before($this->user, 'delete');

        $this->assertTrue($result);
    }
}
```

## Policy vs Gate

| Feature | Policy | Gate |
|---|---|---|
| Model-specific | Yes | No |
| CRUD methods | Built-in | Custom |
| Registration | `$policies` array | `Gate::define()` |
| Use case | Resource authorization | Global permissions |
| Testing | Unit tests | Integration tests |
