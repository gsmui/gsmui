@props([
    'images' => [],
    'columns' => 4,
    'gap' => 2,
    'distortStrength' => 20,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden"
            x-data="{ 
                distX: 0, 
                distY: 0,
                scale: 1
            }"
            @mouseenter="
                distX = 0; distY = 0; scale = 1.1;
            "
            @mouseleave="
                distX = 0; distY = 0; scale = 1;
            "
            :style="`transform: translate(${distX}px, ${distY}px) scale(${scale}); transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); z-index: ${scale > 1 ? 10 : 1};`"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="aspect-square w-full object-cover"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
            <div class="absolute inset-0 ring-1 ring-inset ring-black/5 pointer-events-none"></div>
        </div>
    @endforeach
</div>
