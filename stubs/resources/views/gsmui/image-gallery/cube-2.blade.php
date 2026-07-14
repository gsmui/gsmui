@props([
    'images' => [],
    'size' => '280px',
])

@php
    $faces = array_slice($images, 0, 6);
    while (count($faces) < 6) {
        $faces[] = $faces[count($faces) % count($images)];
    }
@endphp

<div 
    {{ $attributes->class(["flex items-center justify-center h-[500px]"]) }}
    x-data="{ rotateX: -20, rotateY: 0 }"
>
    <div 
        class="relative"
        style="width: {{ $size }}; height: {{ $size }}; perspective: 800px; transform-style: preserve-3d;"
    >
        <div 
            class="relative w-full h-full"
            :style="`transform: rotateX(${rotateX}deg) rotateY(${rotateY}deg); transform-style: preserve-3d; transition: transform 0.5s ease-out;`"
        >
            @foreach($faces as $index => $face)
                @php
                    $transforms = [
                        'rotateY(0deg) translateZ(calc({{ $size }} / 2))',
                        'rotateY(180deg) translateZ(calc({{ $size }} / 2))',
                        'rotateY(90deg) translateZ(calc({{ $size }} / 2))',
                        'rotateY(-90deg) translateZ(calc({{ $size }} / 2))',
                        'rotateX(90deg) translateZ(calc({{ $size }} / 2))',
                        'rotateX(-90deg) translateZ(calc({{ $size }} / 2))',
                    ];
                @endphp
                <div class="absolute inset-0" style="transform: {{ $transforms[$index] }}; backface-visibility: hidden;">
                    <img src="{{ $face['src'] ?? $face }}" alt="" class="w-full h-full object-cover rounded-xl shadow-2xl" />
                </div>
            @endforeach
        </div>
    </div>

    <div class="absolute bottom-8 flex gap-4">
        <button @click="rotateY -= 90" class="rounded-full bg-white dark:bg-zinc-800 p-3 shadow-lg hover:scale-110 transition-transform">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button @click="rotateX -= 15" class="rounded-full bg-white dark:bg-zinc-800 p-3 shadow-lg hover:scale-110 transition-transform">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
        </button>
        <button @click="rotateX += 15" class="rounded-full bg-white dark:bg-zinc-800 p-3 shadow-lg hover:scale-110 transition-transform">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
        </button>
        <button @click="rotateY += 90" class="rounded-full bg-white dark:bg-zinc-800 p-3 shadow-lg hover:scale-110 transition-transform">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
    </div>
</div>
