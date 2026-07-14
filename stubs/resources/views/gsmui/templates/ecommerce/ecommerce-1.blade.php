@props([
    'store' => 'ModernShop',
    'categories' => ['All', 'Clothing', 'Electronics', 'Home', 'Accessories'],
    'products' => [
        ['name' => 'Minimalist Watch', 'price' => '$129', 'rating' => '4.8'],
        ['name' => 'Leather Backpack', 'price' => '$89', 'rating' => '4.6'],
        ['name' => 'Wireless Earbuds', 'price' => '$59', 'rating' => '4.9'],
        ['name' => 'Cotton T-Shirt', 'price' => '$29', 'rating' => '4.5'],
        ['name' => 'Desk Lamp', 'price' => '$49', 'rating' => '4.7'],
        ['name' => 'Notebook Set', 'price' => '$19', 'rating' => '4.4'],
        ['name' => 'Ceramic Mug', 'price' => '$15', 'rating' => '4.8'],
        ['name' => 'Phone Case', 'price' => '$25', 'rating' => '4.3'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$store" />
            <div class="flex items-center gap-6">
                <span class="text-sm text-zinc-500 cursor-pointer">{{ __('Cart (0)') }}</span>
                <gsmui:button size="sm" variant="outline">{{ __('Account') }}</gsmui:button>
            </div>
        </div>
    </header>

    <div class="mx-auto max-w-7xl px-6 py-8">
        <div class="mb-8 flex flex-wrap gap-2">
            @foreach ($categories as $cat)
                <span class="rounded-full border border-zinc-200 dark:border-white/10 px-4 py-1.5 text-sm {{ $loop->first ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800' }} cursor-pointer transition-all">{{ __($cat) }}</span>
            @endforeach
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($products as $product)
                <div class="group cursor-pointer">
                    <div class="aspect-square rounded-xl bg-zinc-100 dark:bg-zinc-800 transition group-hover:shadow-md"></div>
                    <div class="mt-3">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-white group-hover:text-blue-600 transition-colors">{{ $product['name'] }}</h3>
                        <div class="mt-1 flex items-center justify-between">
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $product['price'] }}</span>
                            <span class="text-xs text-zinc-400">★ {{ $product['rating'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center gap-2">
            @foreach ([1, 2, 3] as $page)
                <span class="flex h-8 w-8 items-center justify-center rounded-md text-sm {{ $page === 1 ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800' }} cursor-pointer">{{ $page }}</span>
            @endforeach
        </div>
    </div>
</div>
