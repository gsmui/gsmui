@props([
    'buttons' => [
        ['label' => 'Get Started', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Watch Trailer', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-b from-zinc-900 to-zinc-800 text-white overflow-hidden') }}>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(120,119,198,0.15),transparent_50%)]" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">
                Discover<br>
                <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">Gsmui Pro</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-zinc-400">
                Build seamless UI experiences using Gsmui Pro components. Enhance your workflow with high-performance, modern designs.
            </p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-white px-8 py-3 text-sm font-semibold text-zinc-900 hover:bg-zinc-100 transition-all duration-200">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-8 py-3 text-sm font-semibold text-zinc-300 hover:bg-white/5 transition-all duration-200">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                            {{ $button['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
