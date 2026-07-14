@props([
    'buttons' => [
        ['label' => 'Get Early Access', 'href' => '#', 'style' => 'primary'],
        ['label' => 'See Features', 'href' => '#', 'style' => 'secondary'],
    ],
    'features' => [
        ['icon' => 'bolt', 'title' => 'Fast Growth', 'desc' => 'Scale from 0 to millions of users, our proven framework'],
        ['icon' => 'clock', 'title' => 'Quick Launch', 'desc' => 'Deploy your MVP in days, not months, with our starter kits'],
        ['icon' => 'users', 'title' => 'Community', 'desc' => 'Join 10k+ founders sharing knowledge and experiences'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-b from-orange-50 to-white dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-orange-100 dark:bg-orange-900/30 px-4 py-1.5 text-sm font-medium text-orange-700 dark:text-orange-300">
                <span class="size-2 rounded-full bg-orange-500" aria-hidden="true"></span>
                Now in Public Beta
            </div>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-6xl">
                Launch Your<br>
                <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">Startup</span>
                in Days
            </h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                Everything you need to build, launch, and scale your startup. From idea to IPO, we've got the tools and community to help you succeed.
            </p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}"
                       @class([
                           'rounded-xl px-8 py-3 text-sm font-semibold transition-all duration-200',
                           'bg-orange-600 text-white shadow-sm hover:bg-orange-500' => $button['style'] === 'primary',
                           'border border-zinc-300 dark:border-white/10 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5' => $button['style'] !== 'primary',
                       ])>{{ $button['label'] }}</a>
                @endforeach
            </div>
            <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-3 text-left">
                @foreach ($features as $feature)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6">
                        <div class="mb-4 flex size-12 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-900/30">
                            @if ($feature['icon'] === 'bolt')
                                <svg class="size-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                            @elseif ($feature['icon'] === 'clock')
                                <svg class="size-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @elseif ($feature['icon'] === 'users')
                                <svg class="size-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                            @endif
                        </div>
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $feature['title'] }}</h3>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
            <p class="mt-8 text-sm text-zinc-400 dark:text-zinc-500">Trusted by 2,000+ startups · $100M+ raised by our users · 50+ successful exits</p>
        </div>
    </div>
</div>
