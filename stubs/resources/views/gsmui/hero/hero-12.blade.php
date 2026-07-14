@props([
    'buttons' => [
        ['label' => 'Apply Now', 'href' => '#', 'style' => 'primary'],
    ],
    'stats' => [
        ['value' => '2,943', 'label' => 'Cards Delivered'],
        ['value' => '$1M+', 'label' => 'Transaction Completed'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-b from-slate-900 to-slate-800 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-zinc-300"><span aria-hidden="true">💳</span> Special Offer</div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">
                    A special credit card<br>made for <span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Developers</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-400">
                    Gsmui Pro offers a tailored credit card for developers, streamlining expenses and providing rewards for tech enthusiasts.
                </p>
                <div class="mt-10 flex gap-8">
                    @foreach ($stats as $stat)
                        <div><p class="text-2xl font-bold text-cyan-400">{{ $stat['value'] }}</p><p class="text-sm text-zinc-400">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-cyan-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 transition-all duration-200">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="relative">
                <div class="aspect-[1.586/1] rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 p-8 shadow-2xl">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-white/70">Gsmui Pro</p>
                            <p class="text-lg font-bold mt-1">Developer Card</p>
                        </div>
                        <svg class="size-10 text-white/80" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="mt-12">
                        <p class="text-2xl font-mono tracking-widest">•••• •••• •••• 4242</p>
                        <div class="mt-4 flex items-center justify-between text-sm"><span>CARDHOLDER</span><span>VALID THRU 12/28</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
