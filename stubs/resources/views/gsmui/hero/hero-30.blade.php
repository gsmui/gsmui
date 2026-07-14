@props([
    'buttons' => [
        ['label' => 'Feedback', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Download Gsmui Pro', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-purple-900 to-indigo-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Give Gsmui Pro feedback<br>by using <span class="text-purple-300">Code</span></h1>
            <div class="mt-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm">Join with <strong>6969+</strong> Developers</div>
            <p class="mt-4 text-purple-200">and start to give feedback at Gsmui Pro</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-white px-8 py-3 text-sm font-semibold text-purple-900 hover:bg-purple-50 transition-all">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="rounded-xl border border-white/20 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-all">{{ $button['label'] }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
