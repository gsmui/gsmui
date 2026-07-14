@props([
    'buttons' => [
        ['label' => 'Shop Accessories', 'href' => '#', 'style' => 'primary'],
    ],
    'stats' => [
        ['value' => '38,942', 'label' => 'Orders Delivered'],
        ['value' => '14,344', 'label' => 'Happy Customers'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Discover the Best Fashion<br><span class="text-amber-600 dark:text-amber-400">Accessories</span> for Every Occasion</h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Elevate your style with our curated selection of fashion accessories.</p>
                <div class="mt-10 flex gap-8">
                    @foreach ($stats as $stat)
                        <div><p class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $stat['value'] }}</p><p class="text-sm text-zinc-500">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-amber-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-amber-500 transition-all duration-200">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="aspect-[3/4] rounded-2xl bg-gradient-to-br from-amber-200 to-yellow-200 dark:from-amber-900/30 dark:to-yellow-800/20" aria-hidden="true"></div>
                <div class="aspect-[3/4] rounded-2xl bg-gradient-to-br from-yellow-200 to-amber-200 dark:from-yellow-900/30 dark:to-amber-800/20 mt-4" aria-hidden="true"></div>
                <div class="aspect-[3/4] rounded-2xl bg-gradient-to-br from-orange-200 to-amber-200 dark:from-orange-900/30 dark:to-amber-800/20" aria-hidden="true"></div>
            </div>
        </div>
    </div>
</div>
