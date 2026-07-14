@props([
    'buttons' => [
        ['label' => 'Open Account', 'href' => '#', 'style' => 'primary'],
    ],
    'stats' => [
        ['value' => '256-bit', 'label' => 'Encryption'],
        ['value' => '$5M', 'label' => 'FDIC Insured'],
        ['value' => '24/7', 'label' => 'Monitoring'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-slate-800 to-slate-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-zinc-300"><span aria-hidden="true">🔒</span> Bank-Grade Security</div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Modern Banking for<br><span class="bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">Digital Life</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-400">Experience seamless financial management with our cutting-edge platform.</p>
                <div class="mt-8 flex gap-8">
                    @foreach ($stats as $stat)
                        <div><p class="text-2xl font-bold text-emerald-400">{{ $stat['value'] }}</p><p class="text-xs text-zinc-400">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-emerald-600 px-8 py-3 text-sm font-semibold text-white hover:bg-emerald-500 transition-all">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
                <div class="flex items-center justify-between border-b border-white/10 pb-4"><span class="text-sm font-medium">Account Overview</span><span class="flex items-center gap-1.5 text-xs text-emerald-400"><span class="size-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span> Live</span></div>
                <div class="mt-6"><p class="text-xs text-zinc-400">Total Balance</p><p class="text-3xl font-bold">$24,830.50</p><p class="text-sm text-emerald-400">+$1,250 this month</p></div>
                <div class="mt-6 space-y-4">
                    <div class="flex justify-between"><span class="text-sm text-zinc-400">Savings</span><span class="font-medium">$18,200</span></div>
                    <div class="h-1.5 rounded-full bg-zinc-700"><div class="h-1.5 w-[73%] rounded-full bg-emerald-500"></div></div>
                    <div class="flex justify-between"><span class="text-sm text-zinc-400">Investments</span><span class="font-medium">$6,630</span></div>
                    <div class="h-1.5 rounded-full bg-zinc-700"><div class="h-1.5 w-[27%] rounded-full bg-cyan-500"></div></div>
                </div>
                <div class="mt-4 flex items-center justify-between border-t border-white/10 pt-4"><span class="text-sm text-zinc-400">Monthly Growth</span><span class="text-sm font-medium text-emerald-400">+12.5%</span></div>
            </div>
        </div>
    </div>
</div>
