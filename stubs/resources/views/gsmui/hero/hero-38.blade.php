@props([
    'buttons' => [
        ['label' => 'Get Notified', 'href' => '#', 'style' => 'primary'],
    ],
    'stats' => [
        ['value' => '10k+', 'label' => 'Early Users'],
        ['value' => '99.9%', 'label' => 'Uptime'],
        ['value' => '+340%', 'label' => 'Growth'],
        ['value' => '24h', 'label' => 'Launch'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-violet-900 to-indigo-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-violet-200"><span aria-hidden="true">🚀</span> Launching in 24 Hours</div>
            <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">The Future<br><span class="bg-gradient-to-r from-violet-300 to-indigo-300 bg-clip-text text-transparent">Starts Now</span></h1>
            <p class="mt-6 text-lg leading-8 text-zinc-300">Join thousands of early adopters experiencing the next generation of innovation.</p>
            <div class="mt-10 flex items-center justify-center gap-8">
                @foreach ($stats as $stat)
                    <div><p class="text-3xl font-bold text-violet-300">{{ $stat['value'] }}</p><p class="text-xs text-zinc-400">{{ $stat['label'] }}</p></div>
                @endforeach
            </div>
            <div class="mt-10 inline-flex items-center gap-6 rounded-2xl border border-white/10 bg-white/5 px-8 py-6 backdrop-blur-sm">
                <div class="text-center"><p class="text-4xl font-bold text-violet-300">23</p><p class="text-xs text-zinc-400">HRS</p></div><div class="text-4xl text-zinc-500">:</div>
                <div class="text-center"><p class="text-4xl font-bold text-violet-300">14</p><p class="text-xs text-zinc-400">MIN</p></div><div class="text-4xl text-zinc-500">:</div>
                <div class="text-center"><p class="text-4xl font-bold text-violet-300">27</p><p class="text-xs text-zinc-400">SEC</p></div><div class="text-4xl text-zinc-500">:</div>
                <div class="text-center"><p class="text-4xl font-bold text-violet-300">45</p><p class="text-xs text-zinc-400">MS</p></div>
            </div>
            <div class="mt-10">
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}" class="rounded-xl bg-violet-600 px-8 py-3 text-sm font-semibold text-white hover:bg-violet-500 transition-all">{{ $button['label'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
