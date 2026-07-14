@props([
    'buttons' => [
        ['label' => 'Start Free Trial', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Learn More', 'href' => '#', 'style' => 'secondary'],
    ],
    'stats' => [
        ['value' => '99.9%', 'label' => 'Accuracy', 'sub' => 'Smart AI'],
        ['value' => '<100ms', 'label' => 'Response', 'sub' => 'Lightning'],
        ['value' => '10x', 'label' => 'Faster', 'sub' => 'Precision'],
        ['value' => '+250%', 'label' => 'Performance', 'sub' => 'Growth'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-cyan-600 to-blue-700 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-cyan-200"><span aria-hidden="true">🤖</span> Powered by Advanced AI</div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Next-Gen<br><span class="bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">AI Platform</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-300">Harness the power of artificial intelligence to transform your business.</p>
                <div class="mt-10 flex items-center gap-4">
                    @foreach ($buttons as $button)
                        @if ($button['style'] === 'primary')
                            <a href="{{ $button['href'] }}" class="rounded-xl bg-white px-8 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50 transition-all">{{ $button['label'] }}</a>
                        @else
                            <a href="{{ $button['href'] }}" class="rounded-xl border border-white/20 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-all">{{ $button['label'] }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($stats as $stat)
                    <div class="rounded-xl border border-white/10 bg-white/5 p-4"><p class="text-3xl font-bold text-cyan-300">{{ $stat['value'] }}</p><p class="text-sm text-zinc-300">{{ $stat['label'] }}</p><p class="text-xs text-zinc-400">{{ $stat['sub'] }}</p></div>
                @endforeach
            </div>
        </div>
    </div>
</div>
