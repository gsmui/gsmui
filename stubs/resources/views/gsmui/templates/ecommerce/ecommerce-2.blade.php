@props([
    'store' => 'Luxe Store',
    'featured' => ['name' => 'Premium Leather Jacket', 'price' => '$299', 'desc' => 'Handcrafted from Italian leather.'],
    'categories' => [
        ['name' => 'New Arrivals', 'count' => 24],
        ['name' => 'Best Sellers', 'count' => 18],
        ['name' => 'Sale', 'count' => 12],
    ],
    'newArrivals' => [
        ['name' => 'Silk Scarf', 'price' => '$65'],
        ['name' => 'Cashmere Sweater', 'price' => '$149'],
        ['name' => 'Wool Coat', 'price' => '$249'],
        ['name' => 'Denim Jacket', 'price' => '$119'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$store" />
            <div class="flex items-center gap-6 text-sm text-zinc-500">
                <span class="cursor-pointer">{{ __('Shop') }}</span>
                <span class="cursor-pointer">{{ __('Cart (0)') }}</span>
            </div>
        </div>
    </header>

    <section class="bg-zinc-100 dark:bg-zinc-900 px-6 py-20">
        <div class="mx-auto grid max-w-7xl items-center gap-12 lg:grid-cols-2">
            <div>
                <gsmui:badge class="mb-4">{{ __('Featured') }}</gsmui:badge>
                <h1 class="text-4xl font-bold text-zinc-900 dark:text-white">{{ $featured['name'] }}</h1>
                <p class="mt-3 text-zinc-500">{{ $featured['desc'] }}</p>
                <p class="mt-4 text-3xl font-bold text-zinc-900 dark:text-white">{{ $featured['price'] }}</p>
                <gsmui:button variant="primary" class="mt-6">{{ __('Shop Now') }}</gsmui:button>
            </div>
            <div class="aspect-[4/3] rounded-2xl bg-zinc-200 dark:bg-zinc-800"></div>
        </div>
    </section>

    <main class="mx-auto max-w-7xl px-6 py-16">
        <section class="mb-16">
            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ($categories as $cat)
                    <div class="cursor-pointer rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8 text-center transition hover:shadow-lg">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __($cat['name']) }}</h3>
                        <p class="mt-1 text-sm text-zinc-500">{{ $cat['count'] }} {{ __('items') }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('New Arrivals') }}</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($newArrivals as $product)
                    <div class="group cursor-pointer">
                        <div class="aspect-[3/4] rounded-xl bg-zinc-100 dark:bg-zinc-800 transition group-hover:shadow-md"></div>
                        <div class="mt-3">
                            <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $product['name'] }}</h3>
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $product['price'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <section class="bg-zinc-50 dark:bg-zinc-900 px-6 py-16 text-center">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Join our newsletter') }}</h2>
        <p class="mt-2 text-sm text-zinc-500">{{ __('Get 10% off your first order.') }}</p>
        <div class="mx-auto mt-6 flex max-w-md gap-3">
            <input type="email" placeholder="{{ __('your@email.com') }}" class="flex-1 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 px-4 py-3 text-sm outline-none" />
            <gsmui:button variant="primary">{{ __('Subscribe') }}</gsmui:button>
        </div>
    </section>
</div>
