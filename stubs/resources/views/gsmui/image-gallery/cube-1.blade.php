@props([
    'images' => [],
    'size' => '300px',
    'speed' => 8,
])

@php
    $faces = array_slice($images, 0, 6);
    while (count($faces) < 6) {
        $faces[] = $faces[count($faces) % count($images)];
    }
@endphp

<div {{ $attributes->class(["flex items-center justify-center h-[500px] perspective-1000"]) }}>
    <div 
        class="relative transform-style-3d animate-cube"
        style="width: {{ $size }}; height: {{ $size }}; animation-duration: {{ $speed }}s;"
    >
        {{-- Front --}}
        <div class="absolute inset-0 backface-hidden" style="transform: translateZ(calc({{ $size }} / 2));">
            <img src="{{ $faces[0]['src'] ?? $faces[0] }}" alt="" class="w-full h-full object-cover rounded-xl" />
        </div>
        {{-- Back --}}
        <div class="absolute inset-0 backface-hidden" style="transform: rotateY(180deg) translateZ(calc({{ $size }} / 2));">
            <img src="{{ $faces[1]['src'] ?? $faces[1] }}" alt="" class="w-full h-full object-cover rounded-xl" />
        </div>
        {{-- Right --}}
        <div class="absolute inset-0 backface-hidden" style="transform: rotateY(90deg) translateZ(calc({{ $size }} / 2));">
            <img src="{{ $faces[2]['src'] ?? $faces[2] }}" alt="" class="w-full h-full object-cover rounded-xl" />
        </div>
        {{-- Left --}}
        <div class="absolute inset-0 backface-hidden" style="transform: rotateY(-90deg) translateZ(calc({{ $size }} / 2));">
            <img src="{{ $faces[3]['src'] ?? $faces[3] }}" alt="" class="w-full h-full object-cover rounded-xl" />
        </div>
        {{-- Top --}}
        <div class="absolute inset-0 backface-hidden" style="transform: rotateX(90deg) translateZ(calc({{ $size }} / 2));">
            <img src="{{ $faces[4]['src'] ?? $faces[4] }}" alt="" class="w-full h-full object-cover rounded-xl" />
        </div>
        {{-- Bottom --}}
        <div class="absolute inset-0 backface-hidden" style="transform: rotateX(-90deg) translateZ(calc({{ $size }} / 2));">
            <img src="{{ $faces[5]['src'] ?? $faces[5] }}" alt="" class="w-full h-full object-cover rounded-xl" />
        </div>
    </div>
</div>

<style>
.perspective-1000 { perspective: 1000px; }
.transform-style-3d { transform-style: preserve-3d; }
.backface-hidden { backface-visibility: hidden; }
@keyframes cube {
    0% { transform: rotateX(-15deg) rotateY(0deg); }
    25% { transform: rotateX(-15deg) rotateY(90deg); }
    50% { transform: rotateX(-15deg) rotateY(180deg); }
    75% { transform: rotateX(-15deg) rotateY(270deg); }
    100% { transform: rotateX(-15deg) rotateY(360deg); }
}
.animate-cube { animation: cube linear infinite; }
</style>
