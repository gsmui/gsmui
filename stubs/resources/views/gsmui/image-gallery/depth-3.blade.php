@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'focusDepth' => 200,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        @php
            $depth = ($index % 3) * 50;
        @endphp
        <div 
            class="group relative overflow-hidden rounded-xl transition-all duration-500"
            :style="`transform: translateZ({{ $depth }}px); filter: blur({{ $depth > 0 ? 1 : 0 }}px);`"
            @mouseenter="$el.style.filter = 'blur(0)'; $el.style.transform = 'translateZ({{ $focusDepth }}px) scale(1.1)'; $el.style.zIndex = '10';"
            @mouseleave="$el.style.filter = ''; $el.style.transform = ''; $el.style.zIndex = '';"
        >
            <div class="aspect-square overflow-hidden">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
            </div>
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
            <div class="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                <p class="text-sm font-semibold text-white bg-black/50 backdrop-blur-sm rounded-full px-3 py-1">{{ $image['title'] ?? 'Image' }}</p>
            </div>
        </div>
    @endforeach
</div>
