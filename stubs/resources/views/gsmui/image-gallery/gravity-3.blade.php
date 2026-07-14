@props([
    'images' => [],
    'orbitSize' => '400px',
    'speed' => 20,
    'imageSize' => '100px',
])

<div 
    {{ $attributes->class(["relative flex items-center justify-center h-[500px]"]) }}
    x-data="{ angle: 0 }"
    x-init="setInterval(() => angle = (angle + 1) % 360, {{ 1000 / 60 }})"
>
    {{-- Center piece --}}
    <div class="absolute w-48 h-48 rounded-full overflow-hidden shadow-2xl z-20 border-4 border-white dark:border-zinc-800">
        @if(isset($images[0]))
            <img 
                src="{{ $images[0]['src'] ?? $images[0] }}" 
                alt=""
                class="w-full h-full object-cover"
            />
        @endif
    </div>

    {{-- Orbiting images --}}
    @foreach(array_slice($images, 1) as $index => $image)
        @php
            $orbitAngle = (360 / (count($images) - 1)) * $index;
            $radius = 200;
        @endphp
        <div 
            class="absolute w-20 h-20 rounded-full overflow-hidden shadow-xl border-2 border-white dark:border-zinc-700 transition-transform duration-100"
            :style="`
                transform: rotate(${angle + {{ $orbitAngle }}}deg) translateX({{ $radius }}px) rotate(-${angle + {{ $orbitAngle }}}deg);
            `"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt=""
                class="w-full h-full object-cover"
            />
        </div>
    @endforeach

    {{-- Orbit path --}}
    <div class="absolute w-[400px] h-[400px] rounded-full border border-zinc-300 dark:border-zinc-700 border-dashed opacity-30"></div>
</div>
