@props([
    'images' => [],
    'perspective' => '1200px',
    'rotateX' => 60,
    'gap' => 0,
])

<div 
    {{ $attributes->class(["relative h-[500px] overflow-hidden bg-zinc-900"]) }}
    x-data="{ hover: false }"
    @mouseenter="hover = true"
    @mouseleave="hover = false"
>
    <div 
        class="absolute inset-0 flex items-center justify-center origin-bottom"
        style="perspective: {{ $perspective }};"
    >
        <div 
            class="relative w-full h-full grid grid-cols-4 gap-{{ $gap }} transform-gpu"
            :class="{ 'rotateX-[{{ $rotateX }}deg]': !hover }"
            :style="`transform-style: preserve-3d; transform: rotateX(${hover ? 0 : {{ $rotateX }} }deg); transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);`"
        >
            @foreach($images as $index => $image)
                <div 
                    class="relative overflow-hidden group"
                    :style="`transform: translateZ({{ $index * -20 }}px);`"
                >
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? '' }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-125"
                    />
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors"></div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-center text-white z-20">
        <p class="text-sm opacity-60">Hover to reveal</p>
    </div>
</div>
