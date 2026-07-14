@props([
    'buttons' => [
        ['label' => 'Get started for free', 'href' => '#', 'style' => 'primary'],
    ],
    'platforms' => [
        ['icon' => 'desktop', 'title' => 'Desktop', 'desc' => 'Windows & Mac', 'color' => 'blue'],
        ['icon' => 'mobile', 'title' => 'Mobile', 'desc' => 'iOS & Android', 'color' => 'violet'],
        ['icon' => 'web', 'title' => 'Web', 'desc' => 'All browsers', 'color' => 'emerald'],
        ['icon' => 'plugin', 'title' => 'Plugin', 'desc' => 'VS Code', 'color' => 'amber'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-zinc-800 to-zinc-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Take control<br>of your <span class="bg-gradient-to-r from-blue-400 to-violet-400 bg-clip-text text-transparent">UI experience</span><br>with Gsmui Pro</h1>
                <p class="mt-6 text-lg leading-8 text-zinc-400">Helps you build beautiful, responsive web interfaces effortlessly.</p>
                <div class="mt-10 flex items-center gap-4">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-blue-600 px-8 py-3 text-sm font-semibold text-white hover:bg-blue-500 transition-all">{{ $button['label'] }}</a>
                    @endforeach
                </div>
                <p class="mt-4 text-sm text-zinc-500">Available on</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-sm">
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($platforms as $platform)
                        <div class="rounded-xl bg-white/10 p-4 text-center">
                            @if ($platform['icon'] === 'desktop')
                                <svg class="mx-auto size-8 text-{{ $platform['color'] }}-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/></svg>
                            @elseif ($platform['icon'] === 'mobile')
                                <svg class="mx-auto size-8 text-{{ $platform['color'] }}-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m0 0V3h-3"/></svg>
                            @elseif ($platform['icon'] === 'web')
                                <svg class="mx-auto size-8 text-{{ $platform['color'] }}-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                            @elseif ($platform['icon'] === 'plugin')
                                <svg class="mx-auto size-8 text-{{ $platform['color'] }}-400 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/></svg>
                            @endif
                            <p class="font-medium">{{ $platform['title'] }}</p>
                            <p class="text-xs text-zinc-400">{{ $platform['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
