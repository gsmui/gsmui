@props([
    'buttons' => [
        ['label' => 'Start Our 14 Days Free Trial', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Watch 1 Min Intro', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-b from-cyan-600 to-blue-700 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">Communicate<br><span class="text-cyan-200">Better</span></h1>
            <p class="mt-6 text-lg leading-8 text-cyan-100">Gsmui Pro gives you the tools you need to build a professional website effortlessly.</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-white px-8 py-3 text-sm font-semibold text-cyan-700 hover:bg-cyan-50 transition-all duration-200">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl border border-white/20 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-all duration-200">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                            {{ $button['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
