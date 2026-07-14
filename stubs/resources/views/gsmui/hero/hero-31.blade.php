@props([
    'buttons' => [
        ['label' => 'Get Gsmui Pro Now', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Watch Demo', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-rose-50 to-pink-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Craft Beautiful Interfaces<br>with <span class="bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">Gsmui Pro</span></h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">A developer-first design kit that helps you ship gorgeous components with ease and elegance.</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-rose-600 px-8 py-3 text-sm font-semibold text-white hover:bg-rose-500 transition-all">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl border border-zinc-300 dark:border-white/10 px-8 py-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5 transition-all">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                            {{ $button['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>
            <p class="mt-8 text-sm text-zinc-400">No credit card required · Free & open source components</p>
        </div>
    </div>
</div>
