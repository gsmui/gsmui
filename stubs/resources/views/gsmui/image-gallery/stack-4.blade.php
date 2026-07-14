@props([
    'images' => [],
    'maxVisible' => 4,
    'shadowIntensity' => 'heavy',
])

<div 
    {{ $attributes->class(["relative h-[450px] flex items-center justify-center perspective-1000"]) }}
    x-data="{ current: 0, total: {{ count($images) }}, next() { this.current = (this.current + 1) % this.total; } }"
    x-init="setInterval(next, 3000)"
>
    @foreach($images as $index => $image)
        @if($index < $maxVisible)
            <div 
                class="absolute w-80 h-56 rounded-2xl overflow-hidden transition-all duration-700 ease-out"
                :class="{
                    'shadow-2xl': current === {{ $index }},
                }"
                :style="`
                    z-index: {{ $maxVisible - abs($index - (int)($maxVisible / 2)) }};
                    transform: translateY({{ $index * 8 }}px) scale({{ 1 - ($index * 0.05) }});
                    filter: brightness({{ 1 - ($index * 0.15) }});
                    opacity: {{ $index < $maxVisible ? 1 - ($index * 0.2) : 0 }};
                `"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover"
                />
                @if($index === 0)
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <h3 class="font-bold text-white text-lg">{{ $image['title'] ?? 'Image' }}</h3>
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</div>
