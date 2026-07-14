@props([
    'images' => [],
    'speed' => 0.5,
    'height' => 'h-screen',
])

<div 
    {{ $attributes->class(["relative {$height} overflow-hidden"]) }}
    x-data="{ scrollY: 0 }"
    @scroll.window="scrollY = window.scrollY"
>
    @foreach($images as $index => $image)
        @php
            $layerSpeed = ($index + 1) * $speed;
            $zIndex = count($images) - $index;
        @endphp
        <div 
            class="absolute inset-0"
            :style="`transform: translateY(${scrollY * $layerSpeed}px); z-index: {{ $zIndex }};`"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover"
            />
            @if($index === 0)
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white" :style="`transform: translateY(${scrollY * 0.3}px);`">
                        <h1 class="text-5xl font-bold mb-4">{{ $image['title'] ?? 'Parallax Gallery' }}</h1>
                        <p class="text-xl opacity-80">{{ $image['subtitle'] ?? 'Scroll to explore' }}</p>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
