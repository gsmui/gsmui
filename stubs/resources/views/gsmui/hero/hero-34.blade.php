@props([
    'buttons' => [
        ['label' => 'Get Started', 'href' => '#', 'style' => 'primary'],
    ],
    'features' => [
        ['icon' => 'bolt', 'desc' => 'Lightning Fast — Optimized performance'],
        ['icon' => 'shield', 'desc' => 'Secure — Enterprise-grade security'],
        ['icon' => 'expand', 'desc' => 'Scalable — Grows with your needs'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-indigo-900 to-violet-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-indigo-200"><span aria-hidden="true">🚀</span> New Release</div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">The Future of<br><span class="bg-gradient-to-r from-indigo-400 to-violet-400 bg-clip-text text-transparent">SaaS Development</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-400">Build, deploy, and scale your applications with our cutting-edge platform.</p>
                <div class="mt-8 space-y-3">
                    @foreach ($features as $feature)
                        <div class="flex items-center gap-3">
                            @if ($feature['icon'] === 'bolt')
                                <svg class="size-5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            @elseif ($feature['icon'] === 'shield')
                                <svg class="size-5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            @elseif ($feature['icon'] === 'expand')
                                <svg class="size-5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                            @endif
                            <span class="text-sm text-zinc-300">{{ $feature['desc'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-indigo-600 px-8 py-3 text-sm font-semibold text-white hover:bg-indigo-500 transition-all">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
                <div class="flex items-center justify-between border-b border-white/10 pb-4"><span class="text-sm font-medium">Dashboard</span><span class="flex items-center gap-1.5 text-xs text-emerald-400"><span class="size-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span> Live</span></div>
                <div class="mt-6 space-y-4">
                    <div class="flex justify-between"><span class="text-sm text-zinc-400">Uptime</span><span class="font-medium text-emerald-400">99.9%</span></div>
                    <div class="h-2 rounded-full bg-zinc-700"><div class="h-2 w-[99.9%] rounded-full bg-emerald-500"></div></div>
                    <div class="flex justify-between"><span class="text-sm text-zinc-400">Support</span><span class="font-medium">24/7</span></div>
                    <div class="h-2 rounded-full bg-zinc-700"><div class="h-2 w-full rounded-full bg-indigo-500"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
