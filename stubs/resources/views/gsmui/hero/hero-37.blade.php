@props([
    'buttons' => [
        ['label' => 'Explore Collection', 'href' => '#', 'style' => 'primary'],
    ],
    'features' => [
        ['desc' => 'Premium Materials'],
        ['desc' => 'Handcrafted Excellence'],
        ['desc' => 'Limited Edition'],
        ['desc' => 'Lifetime Warranty'],
    ],
    'stats' => [
        ['value' => '1892', 'label' => 'Since'],
        ['value' => '50+', 'label' => 'Countries'],
        ['value' => '100%', 'label' => 'Satisfaction'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-zinc-900 via-zinc-800 to-stone-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 border border-white/10 rounded-full bg-white/5 px-4 py-1.5 text-sm text-zinc-300"><span aria-hidden="true">✨</span> Luxury Collection</div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Exquisite<br><span class="bg-gradient-to-r from-amber-300 to-yellow-300 bg-clip-text text-transparent">Craftsmanship</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-400">Where timeless elegance meets modern sophistication.</p>
                <div class="mt-8 grid grid-cols-2 gap-4">
                    @foreach ($features as $feature)
                        <div class="flex items-center gap-2"><svg class="size-4 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75"/></svg><span class="text-sm text-zinc-300">{{ $feature['desc'] }}</span></div>
                    @endforeach
                </div>
                <div class="mt-10 flex gap-8">
                    @foreach ($stats as $stat)
                        <div><p class="text-2xl font-bold text-amber-400">{{ $stat['value'] }}</p><p class="text-xs text-zinc-400">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-amber-600 px-8 py-3 text-sm font-semibold text-white hover:bg-amber-500 transition-all">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="aspect-[3/4] rounded-2xl bg-gradient-to-br from-amber-900/40 to-amber-800/20" aria-hidden="true"></div>
                <div class="aspect-[3/4] rounded-2xl bg-gradient-to-br from-stone-900/40 to-amber-900/20 mt-8" aria-hidden="true"></div>
            </div>
        </div>
    </div>
</div>
