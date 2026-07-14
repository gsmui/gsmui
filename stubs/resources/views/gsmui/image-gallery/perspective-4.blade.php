@props([
    'images' => [],
    'tunnelDepth' => 1000,
    'zoomFactor' => 1.5,
])

<div 
    {{ $attributes->class(["relative h-[600px] overflow-hidden bg-black"]) }}
    x-data="{ 
        scrollProgress: 0,
        currentIndex: 0
    }"
    @scroll.window="scrollProgress = Math.min(1, window.scrollY / 500); currentIndex = Math.floor(scrollProgress * {{ count($images) }});"
>
    @foreach($images as $index => $image)
        @php
            $zOffset = ($index - $scrollProgress * count($images)) * 200;
            $scale = max(0.3, 1 - abs($zOffset) / $tunnelDepth);
            $opacity = max(0, 1 - abs($zOffset) / ($tunnelDepth * 0.8));
        @endphp
        <div 
            class="absolute inset-0 flex items-center justify-center transition-all duration-300"
            :style="`transform: translateZ({{ $zOffset }}px) scale(${{ $scale }}); opacity: {{ $opacity }}; z-index: {{ count($images) - $index }};`"
        >
            <div class="relative w-80 h-80 rounded-2xl overflow-hidden shadow-2xl">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-black/30"></div>
            </div>
        </div>
    @endforeach

    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black pointer-events-none"></div>
    
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white text-center">
        <div class="w-1 h-20 bg-white/20 rounded-full overflow-hidden">
            <div class="w-full bg-white rounded-full transition-all duration-300" :style="`height: ${scrollProgress * 100}%`"></div>
        </div>
    </div>
</div>
