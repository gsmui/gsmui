@props([
    'heading' => __('The Everyday Collection'),
    'subtitle' => __('Crafted essentials for modern living. Premium quality, honest pricing.'),
    'price' => '$89',
    'cta' => __('Shop now'),
    'categories' => [__('New Arrivals'), __('Best Sellers'), __('Sale')],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="aspect-square rounded-2xl bg-zinc-100 dark:bg-white/5 border border-zinc-200 dark:border-white/10"></div>
            <div class="space-y-6">
                <div class="flex gap-2">
                    @foreach ($categories as $cat)
                        <span class="rounded-full bg-zinc-100 dark:bg-white/10 px-3 py-1 text-xs text-zinc-600 dark:text-zinc-300">{{ $cat }}</span>
                    @endforeach
                </div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-5xl">{{ $heading }}</h1>
                <p class="text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white tabular-nums">{{ $price }}</div>
                <gsmui:button size="lg">{{ $cta }}</gsmui:button>
            </div>
        </div>
    </div>
</section>
