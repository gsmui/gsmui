@props([
    'buttons' => [
        ['label' => 'Get started', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Watch trailer', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-violet-50 to-fuchsia-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                Elevate your design skills<br>
                <span class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-transparent">Design your<br>perfect interface</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                Discover the art of seamless design and development with Gsmui Pro. Empower your projects with stunning interfaces.
            </p>
            <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">Starting at $9.99/month</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-violet-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 transition-all duration-200">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl border border-zinc-300 dark:border-white/10 px-8 py-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5 transition-all duration-200">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                            {{ $button['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
