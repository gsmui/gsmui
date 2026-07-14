@props([
    'products' => [
        ['name' => 'Summer Dress', 'desc' => 'Elegant & Comfortable', 'price' => '$89', 'badge' => 'Trending', 'badgeColor' => 'rose', 'gradient' => 'from-rose-200 to-rose-100 dark:from-rose-900/30 dark:to-rose-800/20'],
        ['name' => 'Designer Bag', 'desc' => 'Limited Edition', 'price' => '$199', 'badge' => 'New', 'badgeColor' => 'amber', 'gradient' => 'from-amber-200 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/20', 'offset' => true],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-rose-50 via-white to-amber-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center rounded-full bg-rose-100 dark:bg-rose-900/30 px-4 py-1.5 text-sm font-medium text-rose-700 dark:text-rose-300">
                    New Collection 2024
                </div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                    Discover Premium<br>
                    <span class="bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">Fashion</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                    Curated collections from top designers. Express your unique style with our exclusive pieces and trending fashion essentials.
                </p>
                <div class="mt-8 flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                    <span class="flex" aria-hidden="true">★★★★★</span>
                    <span class="font-medium text-zinc-900 dark:text-white">4.9/5</span>
                    <span>from 2.5k+ reviews</span>
                </div>
                <div class="mt-10">
                    <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-zinc-900 dark:bg-white px-8 py-3 text-sm font-semibold text-white dark:text-zinc-900 hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-all duration-200">
                        Shop Now
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($products as $product)
                    <div class="group cursor-pointer rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-4 hover:shadow-lg transition-all duration-300 {{ isset($product['offset']) && $product['offset'] ? 'mt-8' : '' }}">
                        <div class="aspect-[3/4] rounded-lg bg-gradient-to-br {{ $product['gradient'] }} mb-4" aria-hidden="true"></div>
                        <h3 class="font-medium text-zinc-900 dark:text-white">{{ $product['name'] }}</h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $product['desc'] }}</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $product['price'] }}</span>
                            <span class="rounded-full bg-{{ $product['badgeColor'] }}-100 dark:bg-{{ $product['badgeColor'] }}-900/30 px-2 py-0.5 text-xs font-medium text-{{ $product['badgeColor'] }}-700 dark:text-{{ $product['badgeColor'] }}-300">{{ $product['badge'] }}</span>
                        </div>
                    </div>
                @endforeach
                <div class="col-span-2 mt-4 rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="size-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">Free Shipping</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">On orders over $75</p>
                        </div>
                    </div>
                    <span class="text-xs text-zinc-400 dark:text-zinc-500">Limited Time</span>
                </div>
            </div>
        </div>
    </div>
</div>
