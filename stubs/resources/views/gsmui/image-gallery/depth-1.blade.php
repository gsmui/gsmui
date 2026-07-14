@props([
    'images' => [],
    'layers' => 3,
    'depthRange' => 100,
])

<div 
    {{ $attributes->class(["relative min-h-[600px] overflow-hidden"]) }}
    x-data="{ scrollY: 0, mouseX: 0, mouseY: 0 }"
    @scroll.window="scrollY = window.scrollY"
    @mousemove="mouseX = event.clientX; mouseY = event.clientY;"
>
    {{-- Background layer --}}
    <div class="absolute inset-0" :style="`transform: translateZ(-{{ $depthRange }}px) scale(2);`">
        <img src="{{ $images[0]['src'] ?? $images[0] ?? '' }}" class="w-full h-full object-cover opacity-50" />
    </div>

    {{-- Middle layers --}}
    @foreach($images as $index => $image)
        @if($index > 0 && $index <= $layers)
            <div 
                class="absolute rounded-xl overflow-hidden shadow-2xl"
                :style="`
                    left: {{ 10 + ($index * 20) }}%;
                    top: {{ 10 + ($index * 15) }}%;
                    width: {{ 300 - $index * 50 }}px;
                    transform: translateZ({{ $index * 30 }}px) translate(${(mouseX - window.innerWidth/2) * 0.02 * $index}px, ${(mouseY - window.innerHeight/2) * 0.02 * $index}px);
                    transition: transform 0.3s ease-out;
                `"
            >
                <img src="{{ $image['src'] ?? $image }}" alt="" class="w-full h-full object-cover" />
            </div>
        @endif
    @endforeach

    {{-- Foreground content --}}
    <div class="absolute inset-0 flex items-center justify-center z-10" style="transform: translateZ(100px);">
        <div class="text-center text-white bg-black/50 backdrop-blur-sm rounded-2xl p-8">
            <h2 class="text-4xl font-bold mb-4">{{ $images[0]['title'] ?? 'Depth Gallery' }}</h2>
            <p class="text-lg opacity-80">Move your mouse to explore layers</p>
        </div>
    </div>
</div>
