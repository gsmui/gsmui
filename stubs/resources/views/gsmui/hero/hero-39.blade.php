@props([
    'buttons' => [
        ['label' => 'Download Now', 'href' => '#', 'style' => 'primary'],
    ],
    'features' => [
        ['desc' => 'Cross-platform compatibility'],
        ['desc' => 'Real-time synchronization'],
        ['desc' => 'Offline functionality'],
    ],
    'stats' => [
        ['value' => '1M+', 'label' => 'Downloads'],
        ['value' => '4.8★', 'label' => 'Rating'],
        ['value' => 'Free', 'label' => 'Forever'],
    ],
    'devices' => [
        ['icon' => 'mobile', 'title' => 'Mobile', 'desc' => 'iOS & Android'],
        ['icon' => 'desktop', 'title' => 'Desktop', 'desc' => 'Windows & Mac'],
        ['icon' => 'tablet', 'title' => 'Tablet', 'desc' => 'iPad & Android'],
        ['icon' => 'wearable', 'title' => 'Wearables', 'desc' => 'Smart Watches'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-blue-50 dark:bg-blue-900/30 px-4 py-1.5 text-sm text-blue-700 dark:text-blue-300"><span aria-hidden="true">📱</span> Universal App</div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">One App<br><span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Every Device</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Seamlessly experience our product across all your devices.</p>
                <div class="mt-8 space-y-3">
                    @foreach ($features as $feature)
                        <div class="flex items-center gap-3"><svg class="size-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $feature['desc'] }}</span></div>
                    @endforeach
                </div>
                <div class="mt-8 flex gap-8">
                    @foreach ($stats as $stat)
                        <div><p class="text-2xl font-bold text-blue-600">{{ $stat['value'] }}</p><p class="text-xs text-zinc-500">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-blue-600 px-8 py-3 text-sm font-semibold text-white hover:bg-blue-500 transition-all">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($devices as $device)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-4 text-center">
                        @if ($device['icon'] === 'mobile')
                            <svg class="mx-auto size-10 text-zinc-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m0 0V3h-3"/></svg>
                        @elseif ($device['icon'] === 'desktop')
                            <svg class="mx-auto size-10 text-zinc-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/></svg>
                        @elseif ($device['icon'] === 'tablet')
                            <svg class="mx-auto size-10 text-zinc-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                        @elseif ($device['icon'] === 'wearable')
                            <svg class="mx-auto size-10 text-zinc-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.712 4.33a9.027 9.027 0 011.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 00-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 010 9.424m-4.138-5.976a3.736 3.736 0 00-.88-1.388 3.737 3.737 0 00-1.388-.88m2.268 2.268a3.765 3.765 0 010 2.528m-2.268-4.796l-3.448 4.138"/></svg>
                        @endif
                        <p class="font-medium text-sm text-zinc-900 dark:text-white">{{ $device['title'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $device['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
