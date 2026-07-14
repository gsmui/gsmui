@props([
    'buttons' => [
        ['label' => 'Find Opportunities', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Hire Talent', 'href' => '#', 'style' => 'secondary'],
    ],
    'cards' => [
        ['icon' => 'briefcase', 'title' => 'For Developers', 'desc' => 'Find your dream role', 'color' => 'sky'],
        ['icon' => 'building', 'title' => 'For Employers', 'desc' => 'Hire top talent', 'color' => 'indigo'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-r from-sky-50 to-indigo-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                    Connecting Devs with<br>
                    <span class="text-sky-600 dark:text-sky-400">Employers</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                    Connect top developers with the best opportunities. Discover your next big project or join a dynamic team today.
                </p>
                <div class="mt-10 flex items-center gap-4">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}"
                           @class([
                               'rounded-xl px-8 py-3 text-sm font-semibold transition-all duration-200',
                               'bg-sky-600 text-white shadow-sm hover:bg-sky-500' => $button['style'] === 'primary',
                               'border border-zinc-300 dark:border-white/10 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5' => $button['style'] !== 'primary',
                           ])>{{ $button['label'] }}</a>
                    @endforeach
                </div>
                <div class="mt-10 flex items-center gap-6 text-sm text-zinc-500 dark:text-zinc-400">
                    <span class="flex items-center gap-2">Trusted by <strong class="text-zinc-900 dark:text-white">50k+</strong> users</span>
                    <span class="flex items-center gap-1">
                        <span class="flex" aria-hidden="true">★★★★★</span>
                        <span class="text-zinc-900 dark:text-white font-medium">4.1/5</span>
                        <span>(14k Reviews)</span>
                    </span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($cards as $card)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6 text-center">
                        <div class="mx-auto mb-3 flex size-12 items-center justify-center rounded-full bg-{{ $card['color'] }}-100 dark:bg-{{ $card['color'] }}-900/30" aria-hidden="true">
                            @if ($card['icon'] === 'briefcase')
                                <svg class="size-6 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.396c-.093.09-.208.154-.388.212"/></svg>
                            @else
                                <svg class="size-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008z"/></svg>
                            @endif
                        </div>
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $card['title'] }}</h3>
                        <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ $card['desc'] }}</p>
                    </div>
                @endforeach
                <div class="col-span-2 rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6">
                    <div class="flex items-center gap-4">
                        <div class="size-12 rounded-full bg-gradient-to-br from-sky-300 to-sky-500" aria-hidden="true"></div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">Sarah Chen</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Senior Developer at TechCorp</p>
                        </div>
                        <span class="ml-auto rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300">Matched</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
