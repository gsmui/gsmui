@props([
    'buttons' => [
        ['label' => 'Shop Collection', 'href' => '#', 'style' => 'primary'],
    ],
    'stats' => [
        ['value' => '5K+', 'label' => 'Happy Customers'],
        ['value' => '$10M+', 'label' => 'Sales Achieved'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-pink-50 to-rose-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                    Elevate Your Style with<br>
                    <span class="bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">Trending Fashion</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Discover the latest trends in fashion with a touch of tech-savvy elegance. Shop smart, look stunning.</p>
                <div class="mt-10 flex gap-8">
                    @foreach ($stats as $stat)
                        <div><p class="text-3xl font-bold text-pink-600 dark:text-pink-400">{{ $stat['value'] }}</p><p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-pink-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 transition-all duration-200">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="aspect-[3/4] rounded-2xl bg-gradient-to-br from-pink-300 to-rose-200 dark:from-pink-900/30 dark:to-rose-800/20" aria-hidden="true"></div>
                <div class="aspect-[3/4] rounded-2xl bg-gradient-to-br from-rose-300 to-pink-200 dark:from-rose-900/30 dark:to-pink-800/20 mt-8" aria-hidden="true"></div>
            </div>
        </div>
    </div>
</div>
