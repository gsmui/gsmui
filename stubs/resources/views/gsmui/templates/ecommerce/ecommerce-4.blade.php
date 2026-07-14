@props([
    'store' => 'DealZone',
    'discount' => '50% OFF',
    'categories' => ['Electronics', 'Fashion', 'Home', 'Sports', 'Beauty'],
    'saleItems' => [
        ['name' => 'Smart Watch', 'original' => '$199', 'sale' => '$99'],
        ['name' => 'Running Shoes', 'original' => '$120', 'sale' => '$60'],
        ['name' => 'Bluetooth Speaker', 'original' => '$80', 'sale' => '$40'],
        ['name' => 'Yoga Mat', 'original' => '$45', 'sale' => '$22'],
        ['name' => 'Backpack', 'original' => '$70', 'sale' => '$35'],
        ['name' => 'Sunglasses', 'original' => '$60', 'sale' => '$30'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <div class="bg-red-600 px-6 py-3 text-center text-sm font-bold text-white">
        {{ __('FLASH SALE') }} — {{ $discount }} {{ __('everything ends tonight!') }}
    </div>

    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$store" />
            <span class="text-sm text-zinc-500 cursor-pointer">{{ __('Cart (0)') }}</span>
        </div>
    </header>

    <section class="bg-gradient-to-r from-red-600 to-orange-500 px-6 py-16 text-center text-white">
        <h1 class="text-5xl font-bold">{{ $discount }}</h1>
        <p class="mt-3 text-lg text-red-100">{{ __('Limited time only. Don\'t miss out!') }}</p>
        <div class="mx-auto mt-8 flex max-w-md justify-center gap-4 font-mono text-2xl font-bold">
            <div class="rounded-lg bg-white/20 px-4 py-2"><span id="hours">12</span><p class="text-xs font-normal">hrs</p></div>
            <div class="rounded-lg bg-white/20 px-4 py-2"><span id="minutes">34</span><p class="text-xs font-normal">min</p></div>
            <div class="rounded-lg bg-white/20 px-4 py-2"><span id="seconds">56</span><p class="text-xs font-normal">sec</p></div>
        </div>
    </section>

    <main class="mx-auto max-w-7xl px-6 py-16">
        <section class="mb-16">
            <div class="flex flex-wrap justify-center gap-3">
                @foreach ($categories as $cat)
                    <span class="rounded-full border border-zinc-200 dark:border-white/10 px-4 py-1.5 text-sm {{ $loop->first ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'text-zinc-500' }} cursor-pointer transition-all">{{ __($cat) }}</span>
                @endforeach
            </div>
        </section>

        <section class="mb-16">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($saleItems as $item)
                    <div class="group cursor-pointer overflow-hidden rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900">
                        <div class="relative aspect-square bg-zinc-100 dark:bg-zinc-800">
                            <span class="absolute left-3 top-3 rounded-md bg-red-600 px-2 py-0.5 text-xs font-bold text-white">{{ $discount }}</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $item['name'] }}</h3>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="font-bold text-red-600">{{ $item['sale'] }}</span>
                                <span class="text-sm text-zinc-400 line-through">{{ $item['original'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-zinc-50 dark:bg-zinc-900 rounded-2xl p-10 text-center">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Get notified about future sales') }}</h2>
            <div class="mx-auto mt-6 flex max-w-md gap-3">
                <input type="email" placeholder="{{ __('your@email.com') }}" class="flex-1 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 px-4 py-3 text-sm outline-none" />
                <gsmui:button variant="primary" class="bg-red-600 hover:bg-red-700">{{ __('Subscribe') }}</gsmui:button>
            </div>
        </section>
    </main>
</div>
