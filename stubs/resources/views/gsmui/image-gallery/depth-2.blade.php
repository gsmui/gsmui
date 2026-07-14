@props([
    'images' => [],
    'cardCount' => 5,
    'floatSpeed' => 6,
])

<div 
    {{ $attributes->class(["relative h-[500px] bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 overflow-hidden"]) }}
    x-data="{ time: 0 }"
    x-init="setInterval(() => time += 0.1, 50)"
>
    @foreach(array_slice($images, 0, $cardCount) as $index => $image)
        @php
            $angle = $index * (360 / $cardCount);
            $radius = 180;
        @endphp
        <div 
            class="absolute w-48 h-64 rounded-xl overflow-hidden shadow-2xl"
            :style="`
                left: calc(50% + cos((time * {{ $floatSpeed / 10 }} + {{ $angle }}) * 0.017453292519943295) * {{ $radius }}px - 96px);
                top: calc(50% + sin((time * {{ $floatSpeed / 10 }} + {{ $angle }}) * 0.017453292519943295) * {{ $radius / 2 }}px - 128px);
                z-index: {{ $index }};
                transform: scale({{ 1 - $index * 0.05 }}) rotate({{ $index * 5 }}deg);
            `"
        >
            <img src="{{ $image['src'] ?? $image }}" alt="" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        </div>
    @endforeach

    {{-- Depth particles --}}
    @for($i = 0; $i < 30; $i++)
        <div 
            class="absolute w-1 h-1 rounded-full bg-white/30"
            :style="`
                left: {{ rand(10, 90) }}%;
                top: {{ rand(10, 90) }}%;
                animation: depth-float {{ rand(3, 8) }}s ease-in-out infinite;
                animation-delay: {{ $i * 0.2 }}s;
                z-index: {{ rand(1, 10) }};
            `"
        ></div>
    @endfor
</div>

<style>
@keyframes depth-float {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.3; }
    50% { transform: translateY(-30px) scale(1.5); opacity: 0.8; }
}
</style>
