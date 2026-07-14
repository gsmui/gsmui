@props([
    'buttons' => [
        ['label' => 'Get Feedback', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Download iOS App', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-indigo-900 to-purple-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Get meaningful feedback<br>on your <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">code</span></h1>
            <div class="mt-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-indigo-200">Join with <strong>4600+</strong> Developers</div>
            <p class="mt-4 text-indigo-200">and start getting feedback now</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-white px-8 py-3 text-sm font-semibold text-indigo-900 hover:bg-indigo-50 transition-all">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl border border-white/20 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-all">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m0 0V3h-3M7.5 12h9m-9 3.75h9M7.5 19.5h9"/></svg>
                            {{ $button['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
