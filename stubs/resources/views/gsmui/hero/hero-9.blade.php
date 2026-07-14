@props([
    'buttons' => [
        ['label' => 'Get your free chapter now', 'href' => '#', 'style' => 'primary'],
    ],
])

<div {{ $attributes->class('relative bg-amber-50 dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="aspect-[3/4] max-w-sm rounded-2xl bg-gradient-to-br from-amber-200 to-orange-200 dark:from-amber-900/30 dark:to-orange-900/20 shadow-2xl" aria-hidden="true"></div>
                <div class="absolute -bottom-4 -right-4 rounded-xl bg-white dark:bg-zinc-800 p-4 shadow-lg">
                    <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">$19.99</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Paperback</p>
                </div>
            </div>
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                    The only book you'll need<br>
                    <span class="text-amber-600 dark:text-amber-400">to earn more</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                    Learn to earn more money <span class="text-2xl" aria-hidden="true">💰</span> without losing time.
                </p>
                <div class="mt-10 flex items-center justify-center gap-4">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl bg-amber-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-amber-500 transition-all duration-200">
                            {{ $button['label'] }}
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
