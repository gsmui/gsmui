# Blade Templates

> Anonymous components, component classes, slots, attributes, providers, compilers.

## Anonymous Components

gsmui uses Blade anonymous components registered under the `gsmui:` namespace:

```blade
{{-- resources/views/gsmui/button/index.blade.php --}}
@props([
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'href' => null,
    'as' => 'button',
])

@if($href)
    <a href="{{ $href }}" {{ $attributes->class([
        'inline-flex items-center justify-center font-medium transition-colors',
        'rounded-lg' => in_array($size, ['md', 'sm']),
        'rounded-md' => $size === 'xs',
        'h-10 px-4 text-base' => $size === 'md',
        'h-8 px-3 text-sm' => $size === 'sm',
        'h-6 px-2 text-xs' => $size === 'xs',
        'bg-blue-600 text-white hover:bg-blue-700' => $variant === 'primary',
        'bg-zinc-100 text-zinc-900 hover:bg-zinc-200' => $variant === 'secondary',
        'text-zinc-600 hover:text-zinc-900' => $variant === 'ghost',
    ]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class([
        'inline-flex items-center justify-center font-medium transition-colors',
        // ... same classes
    ])->merge(['type' => 'button']) }} {{ $disabled ? 'disabled' : '' }}>
        {{ $slot }}
    </button>
@endif
```

## Component Classes

```php
// app/View/Components/Button.php
class Button extends Component
{
    public function __construct(
        public string $variant = 'primary',
        public string $size = 'md',
        public bool $disabled = false,
        public ?string $href = null,
    ) {}

    public function render()
    {
        return view('components.button');
    }

    public function classes(): string
    {
        return Gsmui::classes('button', [
            'variant' => $this->variant,
            'size' => $this->size,
        ]);
    }
}

// Blade usage
<x-gsmui::button variant="primary" size="md">
    Save Changes
</x-gsmui::button>
```

## Slots

```blade
{{-- card.blade.php --}}
@props(['title', 'description'])

<div {{ $attributes->class(['rounded-xl border border-zinc-200 bg-white p-6 shadow-sm']) }}>
    @if(isset($header))
        <div class="mb-4 border-b border-zinc-200 pb-4">
            {{ $header }}
        </div>
    @endif

    @if($title)
        <h3 class="text-lg font-semibold text-zinc-900">{{ $title }}</h3>
    @endif

    @if($description)
        <p class="mt-1 text-sm text-zinc-500">{{ $description }}</p>
    @endif

    <div class="mt-4">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="mt-4 border-t border-zinc-200 pt-4">
            {{ $footer }}
        </div>
    @endif
</div>

{{-- Usage --}}
<x-gsmui::card title="Product Details" description="Manage your product">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>Header content</span>
        </div>
    </x-slot>

    <p>Card body content</p>

    <x-slot name="footer">
        <div class="flex justify-end">
            <x-gsmui::button>Save</x-gsmui::button>
        </div>
    </x-slot>
</x-gsmui::card>
```

## Attribute Merging

```blade
{{-- input.blade.php --}}
@props([
    'type' => 'text',
    'error' => null,
    'label' => null,
])

<div class="space-y-1">
    @if($label)
        <label {{ $attributes->only('for') }} class="block text-sm font-medium text-zinc-700">
            {{ $label }}
        </label>
    @endif

    <input
        type="{{ $type }}"
        {{ $attributes->class([
            'block w-full rounded-lg border px-3 py-2 text-sm shadow-sm transition-colors',
            'border-zinc-300 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500' => !$error,
            'border-red-500 focus:border-red-500 focus:ring-red-500' => $error,
        ])->except(['label']) }}
    />

    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
```

## Service Providers

```php
// app/Providers/ViewServiceProvider.php
class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share data with all views
        View::share('appName', config('app.name'));

        // Share with specific view
        View::composer('layouts.app', function ($view) {
            $view->with('user', auth()->user());
        });

        // View composers
        View::composer(['components.*'], function ($view) {
            $view->with('theme', session('theme', 'light'));
        });

        // Component boot
        Blade::component('gsmui::button', Button::class);
    }
}
```

## Blade Compilers

```php
// Custom directives
Blade::directive('datetime', function ($expression) {
    return "<?php echo \\Carbon\\Carbon::parse({$expression})->format('M d, Y H:i'); ?>";
});

// Custom syntax
Blade::if('admin', function ($user) {
    return $user->isSuperAdmin();
});

// Usage
@datetime($product->created_at)
@admin($user)
    <p>Admin panel</p>
@endadmin
```

## Component Registration

```php
// In GsmuiProServiceProvider
protected function bootComponentPath(): void
{
    Blade::anonymousComponentPath(
        __DIR__.'/../stubs/resources/views/gsmui',
        'gsmui'
    );
}

// Usage: <x-gsmui::input />, <x-gsmui::button />, etc.
```

## Component Testing

```php
class ButtonComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_primary_variant(): void
    {
        $view = $this->blade(
            '<x-gsmui::button variant="primary">Click me</x-gsmui::button>'
        );

        $view->assertSee('Click me');
        $view->assertSee('bg-blue-600', false);
    }

    public function test_renders_disabled_state(): void
    {
        $view = $this->blade(
            '<x-gsmui::button disabled>Click me</x-gsmui::button>'
        );

        $view->assertSee('disabled', false);
    }
}
```
