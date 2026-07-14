@props([
    'images' => [],
    'layers' => 3,
    'spread' => 100,
])

<div 
    {{ $attributes->class(["relative min-h-[600px] overflow-hidden bg-gradient-to-br from-zinc-900 to-zinc-800"]) }}
    x-data="{ 
        mouseX: 0, 
        mouseY: 0,
        scrollY: 0
    }"
    @mousemove="mouseX = event.clientX; mouseY = event.clientY;"
    @scroll.window="scrollY = window.scrollY"
>
    @foreach($images as $index => $image)
        @php
            $layer = ($index % $layers) + 1;
            $depthFactor = $layer / $layers;
            $x = sin($index * 0.8) * 200 + 300;
            $y = cos($index * 0.6) * 150 + 250;
        @endphp
        <div 
            class="absolute rounded-2xl overflow-hidden shadow-2xl transition-transform duration-500 hover:scale-110 hover:z-50"
            :style="`
                left: {{ $x }}px;
                top: {{ $y }}px;
                width: {{ 200 - $layer * 20 }}px;
                height: {{ 200 - $layer * 20 }}px;
                transform: translate(${(mouseX - window.innerWidth/2) * $depthFactor * 0.05}px, ${(mouseY - window.innerHeight/2) * $depthFactor * 0.05}px);
                z-index: {{ $layers - $layer }};
                opacity: {{ 1 - $depthFactor * 0.3 }};
            `"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover"
            />
        </div>
    @endforeach

    {{-- Floating particles --}}
    @for($i = 0; $i < 20; $i++)
        <div 
            class="absolute w-2 h-2 rounded-full bg-white/20"
            style="left: {{ rand(5, 95) }}%; top: {{ rand(5, 95) }}%; animation: float {{ rand(3, 8) }}s ease-in-out infinite; animation-delay: {{ $i * 0.2 }}s;"
        ></div>
    @endfor
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}
</style>
