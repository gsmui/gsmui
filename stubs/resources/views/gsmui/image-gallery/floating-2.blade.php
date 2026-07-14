@props([
    'images' => [],
    'columns' => 4,
    'gap' => 6,
    'levitateHeight' => 20,
    'shadowSpread' => 40,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative"
            x-data="{ levitate: false }"
            @mouseenter="levitate = true"
            @mouseleave="levitate = false"
        >
            {{-- Shadow --}}
            <div 
                class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3/4 h-4 bg-black/20 rounded-full blur-lg transition-all duration-500"
                :class="{ 'scale-75 opacity-30 translate-y-4': levitate, 'scale-100 opacity-50': !levitate }"
            ></div>

            <div 
                class="relative overflow-hidden rounded-2xl transition-all duration-500"
                :class="{ 'shadow-2xl': levitate }"
                :style="levitate ? 'transform: translateY(-{{ $levitateHeight }}px);' : ''"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="aspect-square w-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
            </div>

            {{-- Levitation glow --}}
            <div 
                class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-4/5 h-8 bg-blue-500/30 rounded-full blur-xl transition-opacity duration-500"
                :class="{ 'opacity-100': levitate, 'opacity-0': !levitate }"
            ></div>
        </div>
    @endforeach
</div>
