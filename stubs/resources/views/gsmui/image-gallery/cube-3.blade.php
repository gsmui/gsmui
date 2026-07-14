@props([
    'images' => [],
    'size' => '250px',
    'unfolded' => false,
])

<div 
    {{ $attributes->class(["flex items-center justify-center min-h-[600px]"]) }}
    x-data="{ open: false }"
>
    <div 
        class="relative"
        style="width: {{ $size }}; height: {{ $size }}; perspective: 1000px; transform-style: preserve-3d;"
    >
        <div 
            class="relative w-full h-full transition-all duration-1000"
            :style="`transform-style: preserve-3d; transform: rotateX(${open ? -30 : 0}deg) rotateY(${open ? 45 : 0}deg);`"
        >
            @foreach(array_slice($images, 0, 6) as $index => $image)
                @php
                    $transforms = [
                        'translateZ(0)',
                        'rotateY(180deg) translateZ(0)',
                        'rotateY(90deg) translateZ(0)',
                        'rotateY(-90deg) translateZ(0)',
                        'rotateX(90deg) translateZ(0)',
                        'rotateX(-90deg) translateZ(0)',
                    ];
                    $openTransforms = [
                        'translateZ(calc({{ $size }} / 2))',
                        'rotateY(180deg) translateZ(calc({{ $size }} / 2)) rotateZ(20deg)',
                        'rotateY(90deg) translateZ(calc({{ $size }} / 2)) rotateZ(-20deg)',
                        'rotateY(-90deg) translateZ(calc({{ $size }} / 2)) rotateZ(20deg)',
                        'rotateX(90deg) translateZ(calc({{ $size }} / 2))',
                        'rotateX(-90deg) translateZ(calc({{ $size }} / 2))',
                    ];
                @endphp
                <div 
                    class="absolute inset-0 transition-all duration-1000"
                    :style="`transform: ${open ? '{{ $openTransforms[$index] }}' : '{{ $transforms[$index] }}'}; backface-visibility: hidden;`"
                >
                    <img src="{{ $image['src'] ?? $image }}" alt="" class="w-full h-full object-cover rounded-xl shadow-xl" />
                </div>
            @endforeach
        </div>
    </div>

    <button 
        @click="open = !open"
        class="absolute bottom-8 rounded-full bg-blue-600 px-6 py-3 text-white font-medium shadow-lg hover:bg-blue-700 transition-colors"
    >
        <span x-text="open ? 'Fold' : 'Unfold'"></span>
    </button>
</div>
