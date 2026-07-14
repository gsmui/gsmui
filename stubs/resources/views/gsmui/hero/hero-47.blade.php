@props([
    'buttons' => [
        ['label' => 'Start Exploring', 'href' => '#', 'style' => 'primary'],
        ['label' => 'View Destinations', 'href' => '#', 'style' => 'secondary'],
    ],
    'destinations' => [
        ['name' => 'Bali, Indonesia', 'price' => 'Starting at $899', 'gradient' => 'from-amber-300 to-orange-400'],
        ['name' => 'Santorini, Greece', 'price' => 'Starting at $1,299', 'gradient' => 'from-emerald-300 to-green-400'],
        ['name' => 'Kyoto, Japan', 'price' => 'Starting at $1,499', 'gradient' => 'from-rose-300 to-pink-400'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-b from-sky-800 to-indigo-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">Explore the<br><span class="bg-gradient-to-r from-amber-300 to-yellow-300 bg-clip-text text-transparent">World</span></h1>
            <p class="mt-6 text-lg leading-8 text-sky-200">Discover extraordinary destinations and create unforgettable memories.</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-white px-8 py-3 text-sm font-semibold text-sky-800 hover:bg-sky-50 transition-all">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="rounded-xl border border-white/20 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-all">{{ $button['label'] }}</a>
                    @endif
                @endforeach
            </div>
            <div class="mt-12 grid grid-cols-3 gap-6">
                @foreach ($destinations as $dest)
                    <div class="rounded-2xl bg-white/10 backdrop-blur-sm p-4 text-left">
                        <div class="aspect-[4/3] rounded-xl bg-gradient-to-br {{ $dest['gradient'] }} mb-3" aria-hidden="true"></div>
                        <p class="font-medium">{{ $dest['name'] }}</p>
                        <p class="text-sm text-sky-200">{{ $dest['price'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
