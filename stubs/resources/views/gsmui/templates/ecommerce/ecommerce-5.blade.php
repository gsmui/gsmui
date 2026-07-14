@props([
    'store' => 'StyleHaus',
    'product' => [
        'name' => 'Classic Oxford Shirt',
        'price' => '$89',
        'rating' => '4.8',
        'reviews' => 234,
        'description' => 'Premium cotton oxford shirt with a tailored fit. Perfect for both casual and formal occasions.',
    ],
    'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
    'colors' => ['White', 'Blue', 'Pink', 'Navy'],
    'related' => [
        ['name' => 'Chino Pants', 'price' => '$69'],
        ['name' => 'Linen Blazer', 'price' => '$189'],
        ['name' => 'Silk Tie', 'price' => '$45'],
        ['name' => 'Leather Belt', 'price' => '$55'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$store" />
            <span class="text-sm text-zinc-500 cursor-pointer">{{ __('Cart (0)') }}</span>
        </div>
    </header>

    <div class="mx-auto max-w-7xl px-6 py-12">
        <div class="grid gap-12 lg:grid-cols-2">
            <div class="aspect-[3/4] rounded-2xl bg-zinc-100 dark:bg-zinc-800"></div>

            <div>
                <nav class="mb-4 flex gap-2 text-xs text-zinc-400">
                    <span>{{ __('Home') }}</span>/<span>{{ __('Men') }}</span>/<span>{{ __('Shirts') }}</span>
                </nav>

                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $product['name'] }}</h1>

                <div class="mt-3 flex items-center gap-3">
                    <span class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $product['price'] }}</span>
                    <span class="text-sm text-zinc-400">★ {{ $product['rating'] }} ({{ $product['reviews'] }} {{ __('reviews') }})</span>
                </div>

                <p class="mt-6 text-zinc-600 dark:text-zinc-400">{{ $product['description'] }}</p>

                <div class="mt-8">
                    <h3 class="mb-3 text-sm font-semibold text-zinc-900 dark:text-white">{{ __('Size') }}</h3>
                    <div class="flex gap-2">
                        @foreach ($sizes as $size)
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 dark:border-white/10 text-sm cursor-pointer {{ $loop->first ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'text-zinc-500 hover:border-zinc-400' }}">{{ $size }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="mb-3 text-sm font-semibold text-zinc-900 dark:text-white">{{ __('Color') }}</h3>
                    <div class="flex gap-2">
                        @foreach ($colors as $color)
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 dark:border-white/10 text-xs cursor-pointer {{ $loop->first ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'text-zinc-500 hover:border-zinc-400' }}">{{ __($color) }}</span>
                        @endforeach
                    </div>
                </div>

                <gsmui:button variant="primary" size="lg" class="mt-10 w-full">{{ __('Add to Cart') }}</gsmui:button>
            </div>
        </div>

        <section class="mt-20">
            <h2 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('You might also like') }}</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($related as $item)
                    <div class="group cursor-pointer">
                        <div class="aspect-[3/4] rounded-xl bg-zinc-100 dark:bg-zinc-800 transition group-hover:shadow-md"></div>
                        <div class="mt-3">
                            <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $item['name'] }}</h3>
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $item['price'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
