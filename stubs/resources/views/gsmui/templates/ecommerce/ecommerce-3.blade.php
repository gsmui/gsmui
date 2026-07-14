@props([
    'store' => 'TechGear',
    'breadcrumbs' => ['Home', 'Electronics', 'Audio'],
    'filters' => [
        'Price' => ['Under $50', '$50 — $100', '$100 — $200', 'Over $200'],
        'Brand' => ['Sony', 'Bose', 'Sennheiser', 'JBL'],
        'Color' => ['Black', 'White', 'Blue'],
    ],
    'sortOptions' => ['Newest', 'Price: Low to High', 'Price: High to Low', 'Best Rating'],
    'products' => [
        ['name' => 'Noise Cancelling Headphones', 'price' => '$199', 'rating' => '4.9'],
        ['name' => 'Portable Speaker', 'price' => '$79', 'rating' => '4.7'],
        ['name' => 'Wireless Earbuds Pro', 'price' => '$149', 'rating' => '4.8'],
        ['name' => 'Studio Monitor', 'price' => '$299', 'rating' => '4.6'],
        ['name' => 'Gaming Headset', 'price' => '$89', 'rating' => '4.5'],
        ['name' => 'USB Microphone', 'price' => '$69', 'rating' => '4.7'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$store" />
            <span class="text-sm text-zinc-500 cursor-pointer">{{ __('Cart (0)') }}</span>
        </div>
    </header>

    <div class="mx-auto max-w-7xl px-6 py-8">
        <nav class="mb-6 flex gap-2 text-sm text-zinc-400">
            @foreach ($breadcrumbs as $crumb)
                <span>{{ __($crumb) }}</span>
                @if (!$loop->last)
                    <span>/</span>
                @endif
            @endforeach
        </nav>

        <div class="flex gap-8">
            <aside class="hidden w-56 shrink-0 lg:block">
                @foreach ($filters as $label => $options)
                    <div class="mb-6">
                        <h3 class="mb-3 text-sm font-semibold text-zinc-900 dark:text-white">{{ __($label) }}</h3>
                        <div class="space-y-2">
                            @foreach ($options as $option)
                                <label class="flex items-center gap-2 text-sm text-zinc-500 cursor-pointer">
                                    <span class="h-4 w-4 rounded border border-zinc-300 dark:border-zinc-600"></span>
                                    {{ $option }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </aside>

            <div class="flex-1">
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-sm text-zinc-500">{{ count($products) }} {{ __('results') }}</p>
                    <select class="rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 px-3 py-2 text-sm">
                        @foreach ($sortOptions as $option)
                            <option>{{ __($option) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($products as $product)
                        <div class="group cursor-pointer">
                            <div class="aspect-square rounded-xl bg-zinc-100 dark:bg-zinc-800 transition group-hover:shadow-md"></div>
                            <div class="mt-3">
                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $product['name'] }}</h3>
                                <div class="mt-1 flex items-center justify-between">
                                    <span class="font-bold text-zinc-900 dark:text-white">{{ $product['price'] }}</span>
                                    <span class="text-xs text-zinc-400">★ {{ $product['rating'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 flex justify-center gap-2">
                    @foreach ([1, 2, 3] as $page)
                        <span class="flex h-8 w-8 items-center justify-center rounded-md text-sm {{ $page === 1 ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800' }} cursor-pointer">{{ $page }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
