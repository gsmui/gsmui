@props([
    'buttons' => [
        ['label' => 'Explore Components', 'href' => '#', 'style' => 'primary'],
    ],
    'features' => [
        ['icon' => 'glass', 'title' => 'Premium Quality', 'desc' => 'Handcrafted components', 'color' => 'violet'],
        ['icon' => 'layers', 'title' => 'Layered Design', 'desc' => 'Depth and dimension', 'color' => 'indigo'],
        ['icon' => 'harmony', 'title' => 'Color Harmony', 'desc' => 'Perfect combinations', 'color' => 'purple'],
        ['icon' => 'code', 'title' => 'Clean Code', 'desc' => 'Well-structured & readable', 'color' => 'indigo'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-indigo-950 via-purple-900 to-slate-900 text-white overflow-hidden') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white/5 via-transparent to-transparent" aria-hidden="true"></div>
    <div class="absolute top-20 left-10 size-72 rounded-full bg-violet-500/10 blur-3xl" aria-hidden="true"></div>
    <div class="absolute bottom-20 right-10 size-96 rounded-full bg-indigo-500/10 blur-3xl" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight sm:text-6xl"><span class="bg-gradient-to-r from-white/80 to-white/40 bg-clip-text text-transparent">Glass</span> &<br><span class="bg-gradient-to-r from-violet-300 to-indigo-300 bg-clip-text text-transparent">Brilliance</span></h1>
            <p class="mt-6 text-lg leading-8 text-zinc-400">Experience the future of UI design with stunning glassmorphism effects, transparency, and depth.</p>
            <div class="mt-10 grid grid-cols-2 gap-4">
                @foreach ($features as $feature)
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl">
                        @if ($feature['icon'] === 'glass')
                            <svg class="size-8 text-{{ $feature['color'] }}-300 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>
                        @elseif ($feature['icon'] === 'layers')
                            <svg class="size-8 text-{{ $feature['color'] }}-300 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3"/></svg>
                        @elseif ($feature['icon'] === 'harmony')
                            <svg class="size-8 text-{{ $feature['color'] }}-300 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m0 0a9.003 9.003 0 00-2.424-6.09M15 8a9.003 9.003 0 00-6-2.424M15 8A9.003 9.003 0 1115 8z"/></svg>
                        @elseif ($feature['icon'] === 'code')
                            <svg class="size-8 text-{{ $feature['color'] }}-300 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/></svg>
                        @endif
                        <p class="font-medium">{{ $feature['title'] }}</p>
                        <p class="text-sm text-zinc-400">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-10">
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl bg-white/10 border border-white/20 backdrop-blur-xl px-8 py-3 text-sm font-semibold text-white hover:bg-white/20 transition-all">{{ $button['label'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
