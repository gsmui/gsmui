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
    {{ $attributes->class(["flex items-center justify-center h-[500px] select-none"]) }}
    x-data="{ 
        rotateX: -20, 
        rotateY: 20, 
        isDragging: false, 
        startX: 0, 
        startY: 0,
        startRotX: 0,
        startRotY: 0
    }"
    @mousedown="isDragging = true; startX = $event.clientX; startY = $event.clientY; startRotX = rotateX; startRotY = rotateY; $event.preventDefault();"
    @mousemove.window="if(isDragging) { rotateY = startRotY + (event.clientX - startX) * 0.5; rotateX = startRotX + (event.clientY - startY) * -0.5; }"
    @mouseup.window="isDragging = false"
    @mouseleave.window="isDragging = false"
    style="cursor: grab;"
    :class="{ 'cursor-grabbing': isDragging }"
>
    <div 
        class="relative"
        style="width: {{ $size }}; height: {{ $size }}; perspective: 800px;"
    >
        <div 
            class="relative w-full h-full transition-transform"
            :class="{ 'duration-0': isDragging, 'duration-500': !isDragging }"
            :style="`transform: rotateX(${rotateX}deg) rotateY(${rotateY}deg); transform-style: preserve-3d;`"
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

    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 text-sm text-zinc-500">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
        </svg>
        Drag to rotate
    </div>
</div>
