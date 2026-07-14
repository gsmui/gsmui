@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'barCount' => 20,
    'barColor' => 'white',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-2xl bg-zinc-900"
            x-data="{ active: false, bars: Array.from({length: {{ $barCount }}}, () => Math.random() * 100) }"
            @mouseenter="active = true; bars = Array.from({length: {{ $barCount }}}, () => Math.random() * 100);"
            @mouseleave="active = false"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="aspect-square w-full object-cover transition-all duration-500"
                :class="{ 'brightness-50 scale-110': active }"
            />
            
            {{-- Sound wave overlay --}}
            <div 
                class="absolute inset-0 flex items-end justify-center gap-1 p-4 opacity-0 transition-opacity duration-300"
                :class="{ 'opacity-100': active }"
            >
                @foreach(range(1, $barCount) as $i)
                    <div 
                        class="w-1 rounded-full transition-all duration-300"
                        :style="`
                            height: ${active ? bars[{{ $i - 1 }}] : 20}%;
                            background: {{ $barColor }};
                            opacity: 0.8;
                            animation: wave-bar 0.5s ease-in-out {{ $i * 0.05 }}s infinite alternate;
                        `"
                    ></div>
                @endforeach
            </div>

            <div class="absolute inset-0 flex items-center justify-center">
                <div class="transform transition-all duration-300" :class="{ 'scale-125': active }">
                    <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                        <svg class="h-5 w-5 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
@keyframes wave-bar {
    0% { transform: scaleY(0.5); }
    100% { transform: scaleY(1); }
}
</style>
