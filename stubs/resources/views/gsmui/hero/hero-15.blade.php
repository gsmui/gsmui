@props([
    'buttons' => [
        ['label' => 'Get started', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Watch trailer', 'href' => '#', 'style' => 'secondary'],
    ],
    'features' => [
        ['icon' => 'components', 'title' => 'Components', 'desc' => '50+ ready-to-use', 'color' => 'blue'],
        ['icon' => 'secure', 'title' => 'Secure', 'desc' => 'Enterprise grade', 'color' => 'indigo'],
        ['icon' => 'responsive', 'title' => 'Responsive', 'desc' => 'Mobile first', 'color' => 'violet'],
        ['icon' => 'fast', 'title' => 'Fast', 'desc' => 'Optimized', 'color' => 'rose'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Elevate Your Web Development<br><span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Design with Gsmui Pro</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Your gateway to intuitive and high-performance web design. Build with flexibility, backed by powerful components and seamless integration.</p>
                <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">Starting at $9.99/month</p>
                <div class="mt-8 flex items-center gap-4">
                    @foreach ($buttons as $button)
                        @if ($button['style'] === 'primary')
                            <a href="{{ $button['href'] }}" class="rounded-xl bg-blue-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-all duration-200">{{ $button['label'] }}</a>
                        @else
                            <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl border border-zinc-300 dark:border-white/10 px-8 py-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5 transition-all duration-200">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                                {{ $button['label'] }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-8">
                <div class="grid grid-cols-2 gap-6">
                    @foreach ($features as $feature)
                        <div class="rounded-xl bg-{{ $feature['color'] }}-50 dark:bg-{{ $feature['color'] }}-900/20 p-4">
                            @if ($feature['icon'] === 'components')
                                <svg class="size-8 text-blue-600 dark:text-blue-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6z"/></svg>
                            @elseif ($feature['icon'] === 'secure')
                                <svg class="size-8 text-indigo-600 dark:text-indigo-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            @elseif ($feature['icon'] === 'responsive')
                                <svg class="size-8 text-violet-600 dark:text-violet-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                            @elseif ($feature['icon'] === 'fast')
                                <svg class="size-8 text-rose-600 dark:text-rose-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $feature['title'] }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $feature['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
