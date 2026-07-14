@props([
    'buttons' => [
        ['label' => 'Get 14 Days Free Trial', 'href' => '#', 'style' => 'primary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-slate-900 to-slate-800 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Launch SaaS Projects<br>at <span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Warp Speed</span></h1>
            <p class="mt-6 text-lg leading-8 text-zinc-400">Use Gsmui Pro to build professional-grade UI experiences in minutes, not weeks.</p>
            <div class="mt-10">
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}" class="rounded-xl bg-cyan-600 px-8 py-3 text-sm font-semibold text-white hover:bg-cyan-500 transition-all">{{ $button['label'] }}</a>
                @endforeach
            </div>
            <p class="mt-4 text-sm text-zinc-500">No credit card required • Cancel anytime</p>
        </div>
    </div>
</div>
