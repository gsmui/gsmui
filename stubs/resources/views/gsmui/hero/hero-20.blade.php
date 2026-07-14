@props([
    'buttons' => [
        ['label' => 'Get more customers', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Watch free demo', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-blue-600 to-indigo-700 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-blue-200"><span aria-hidden="true">📧</span> Smart email campaign builder</div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Turn your visitors into<br><span class="text-blue-200">profitable business</span></h1>
                <div class="mt-10 flex items-center gap-4">
                    @foreach ($buttons as $button)
                        @if ($button['style'] === 'primary')
                            <a href="{{ $button['href'] }}" class="rounded-xl bg-white px-8 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50 transition-all">{{ $button['label'] }}</a>
                        @else
                            <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl border border-white/20 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-all">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                                {{ $button['label'] }}
                            </a>
                        @endif
                    @endforeach
                </div>
                <p class="mt-6 text-sm text-blue-200">60 Days free trial · No credit card required</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
                <div class="rounded-xl bg-white/10 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex size-10 items-center justify-center rounded-lg bg-blue-500">
                            <svg class="size-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <div><p class="font-medium">Campaign Summary</p><p class="text-sm text-blue-200">Ready to send</p></div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm"><span>Recipients</span><span class="font-medium">12,450</span></div>
                        <div class="flex justify-between text-sm"><span>Open Rate</span><span class="font-medium text-emerald-300">45.2%</span></div>
                        <div class="flex justify-between text-sm"><span>Click Rate</span><span class="font-medium text-emerald-300">12.8%</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
