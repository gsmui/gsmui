# Livewire Architecture

> Components, properties, actions, wire:model, lifecycle, polling, real-time updates.

## Component Structure

```php
// app/Livewire/Products/ProductList.php
class ProductList extends Component
{
    public string $search = '';
    public string $status = 'all';
    public int $page = 1;
    public int $perPage = 15;
    public ?int $selectedCategory = null;

    protected $listeners = [
        'productCreated' => '$refresh',
        'productUpdated' => '$refresh',
        'productDeleted' => '$refresh',
    ];

    protected $rules = [
        'search' => 'nullable|string|max:255',
        'status' => 'in:all,active,draft,archived',
        'perPage' => 'integer|min:5|max:50',
    ];

    public function updatingSearch(): void
    {
        $this->page = 1;
    }

    public function updatingStatus(): void
    {
        $this->page = 1;
    }

    public function getProductsProperty()
    {
        return Product::query()
            ->when($this->search, fn ($q) =>
                $q->where('name', 'LIKE', "%{$this->search}%")
            )
            ->when($this->status !== 'all', fn ($q) =>
                $q->where('status', $this->status)
            )
            ->when($this->selectedCategory, fn ($q) =>
                $q->where('category_id', $this->selectedCategory)
            )
            ->paginate($this->perPage, ['*'], 'page', $this->page);
    }

    public function render()
    {
        return view('livewire.products.product-list', [
            'products' => $this->products,
        ]);
    }
}
```

## Properties

```php
class ProductForm extends Component
{
    // Public properties (synced with front-end)
    public string $name = '';
    public int $price = 0;
    public ?string $description = null;
    public int $categoryId = 0;

    // Computed properties
    public function getFormattedPriceProperty(): string
    {
        return '$' . number_format($this->price / 100, 2);
    }

    public function getIsValidProperty(): bool
    {
        return !empty($this->name) && $this->price > 0;
    }

    // Protected properties (not synced)
    protected Product $product;

    // Hydration hooks
    public function hydrate(): void
    {
        $this->product = new Product();
    }

    public function dehydrate(): void
    {
        // Clean up before serialization
    }
}
```

## Actions

```php
class ProductForm extends Component
{
    public string $name = '';
    public int $price = 0;

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:100',
        ]);

        $product = Product::create([
            'name' => $this->name,
            'price' => $this->price,
        ]);

        $this->reset(['name', 'price']);
        $this->dispatch('productCreated', $product->id);
    }

    public function delete(int $id): void
    {
        Product::findOrFail($id)->delete();

        $this->dispatch('productDeleted');
    }

    public function toggleStatus(int $id): void
    {
        $product = Product::findOrFail($id);

        $product->update([
            'status' => $product->status === 'active' ? 'draft' : 'active',
        ]);

        $this->dispatch('productUpdated');
    }
}
```

## Wire:model

```blade
{{-- Two-way data binding --}}
<input type="text" wire:model="search" placeholder="Search products..." />

{{-- Debounced --}}
<input type="text" wire:model.live.debounce.300ms="search" />

{{-- Lazy (on blur) --}}
<input type="text" wire:model.blur="email" />

{{-- Numeric --}}
<input type="number" wire:model="price" />

{{-- Select --}}
<select wire:model="status">
    <option value="all">All Status</option>
    <option value="active">Active</option>
    <option value="draft">Draft</option>
</select>

{{-- Checkbox --}}
<input type="checkbox" wire:model="featured" />

{{-- Radio --}}
<input type="radio" wire:model="sort" value="name" />
<input type="radio" wire:model="sort" value="price" />
```

## Lifecycle Hooks

```php
class ProductList extends Component
{
    // Called when component mounts (first render)
    public function mount(): void
    {
        $this->status = request()->query('status', 'all');
    }

    // Called on every render
    public function boot(): void
    {
        // Runs before render
    }

    // Called after render
    public function rendering(): void
    {
        // Post-render logic
    }

    // Called when component dehydrates
    public function dehydrate(): void
    {
        // Clean up
    }

    // Called when component hydrates
    public function hydrate(): void
    {
        // Re-initialize
    }
}
```

## Polling

```blade
{{-- Poll every 5 seconds --}}
<div wire:poll.5s="checkStatus">
    Status: {{ $status }}
</div>

{{-- Poll with condition --}}
<div wire:poll.10s="$refresh" wire:poll.if="$autoRefresh">
    Auto-refreshing content
</div>

{{-- Named method polling --}}
<div wire:poll.3s="updateMetrics">
    {{ $metrics }}
</div>
```

```php
class MetricsDashboard extends Component
{
    public array $metrics = [];

    public function boot(): void
    {
        $this->metrics = $this->fetchMetrics();
    }

    public function updateMetrics(): void
    {
        $this->metrics = $this->fetchMetrics();
    }

    protected function fetchMetrics(): array
    {
        return [
            'orders' => Order::where('created_at', '>=', now()->subHour())->count(),
            'revenue' => Order::where('created_at', '>=', now()->subHour())->sum('total'),
            'users' => User::where('created_at', '>=', now()->subHour())->count(),
        ];
    }
}
```

## Real-Time Updates

```php
class Chat extends Component
{
    public string $message = '';
    public array $messages = [];

    protected $listeners = [
        'BroadcastMessage' => '$refresh',
    ];

    public function broadcastMessage(): void
    {
        $this->validate([
            'message' => 'required|string|max:1000',
        ]);

        broadcast(new MessageSent(
            user: auth()->user(),
            message: $this->message,
        ));

        $this->reset('message');
    }

    public function render()
    {
        return view('livewire.chat');
    }
}

// Broadcast listener
class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public User $user,
        public string $message,
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('chat')];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}
```

## Nested Components

```blade
{{-- Parent --}}
<livewire:products.product-list />

{{-- With props --}}
<livewire:products.product-form :product="$product" />

{{-- With slot --}}
<livewire:products.product-card>
    <x-slot name="actions">
        <button wire:click="edit({{ $product->id }})">Edit</button>
    </x-slot>
</livewire:products.product-card>
```

## Testing Livewire

```php
class ProductListTest extends TestCase
{
    use RefreshDatabase, Livewire;

    public function test_renders_products(): void
    {
        Product::factory()->count(5)->create();

        Livewire::test(ProductList::class)
            ->assertViewHas('products', function ($products) {
                return $products->count() === 5;
            });
    }

    public function test_search_filters_products(): void
    {
        Product::factory()->create(['name' => 'Red Widget']);
        Product::factory()->create(['name' => 'Blue Widget']);
        Product::factory()->create(['name' => 'Green Gear']);

        Livewire::test(ProductList::class)
            ->set('search', 'Widget')
            ->assertViewHas('products', function ($products) {
                return $products->count() === 2;
            });
    }

    public function test_delete_removes_product(): void
    {
        $product = Product::factory()->create();

        Livewire::test(ProductList::class)
            ->call('delete', $product->id)
            ->assertDispatched('productDeleted');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
```
