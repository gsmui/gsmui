@props([
    'buttons' => [
        ['label' => 'Explore all artwork', 'href' => '#', 'style' => 'primary'],
    ],
    'stats' => [
        ['value' => '50k+', 'label' => 'Artwork'],
        ['value' => '17k+', 'label' => 'Artists'],
    ],
    'artworks' => [
        ['title' => 'Ely - The Angry Girl', 'price' => '2.00 ETH', 'usd' => '$9,394', 'gradient' => 'from-purple-400 to-pink-400'],
        ['title' => 'Jenny - Retro Art', 'price' => '1.67 ETH', 'usd' => '$7,627', 'gradient' => 'from-cyan-400 to-blue-400'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-b from-purple-900 via-indigo-900 to-zinc-900 text-white') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-purple-500/20 via-transparent to-transparent" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">
                    Collect rare <span class="text-3xl" aria-hidden="true">✨</span><br>
                    <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">digital artworks</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-400">Buy & sell NFTs from world's top artists with Gsmui Pro</p>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:from-purple-500 hover:to-pink-500 transition-all duration-200">
                            {{ $button['label'] }}
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10 flex gap-8">
                    @foreach ($stats as $stat)
                        <div><p class="text-2xl font-bold">{{ $stat['value'] }}</p><p class="text-sm text-zinc-400">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
            </div>
            <div class="space-y-4">
                @foreach ($artworks as $art)
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                        <div class="aspect-[16/9] rounded-xl bg-gradient-to-br {{ $art['gradient'] }} mb-4" aria-hidden="true"></div>
                        <h3 class="font-semibold">{{ $art['title'] }}</h3>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-sm text-zinc-400">Reserved Price</span>
                            <span class="font-mono text-sm font-medium">{{ $art['price'] }}</span>
                        </div>
                        <p class="text-xs text-zinc-500">({{ $art['usd'] }})</p>
                        <div class="mt-3 flex gap-2">
                            <a href="#" class="flex-1 rounded-lg bg-purple-600 py-2 text-center text-xs font-medium hover:bg-purple-500 transition-all">Place a bid</a>
                            <a href="#" class="flex-1 rounded-lg border border-white/10 py-2 text-center text-xs font-medium hover:bg-white/5 transition-all">View artwork</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
