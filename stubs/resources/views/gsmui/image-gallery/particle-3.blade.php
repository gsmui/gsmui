@props([
    'images' => [],
    'columns' => 3,
    'gap' => 8,
    'connectionColor' => 'rgba(255,255,255,0.2)',
])

<div 
    {{ $attributes->class(["relative grid grid-cols-{$columns} gap-{$gap}"]) }}
    x-data="{ mouseX: 0, mouseY: 0 }"
    @mousemove="mouseX = event.offsetX; mouseY = event.offsetY;"
>
    {{-- Connection lines canvas --}}
    <svg class="absolute inset-0 w-full h-full pointer-events-none z-10">
        @foreach($images as $index => $image)
            @if($index < count($images) - 1)
                <line 
                    x1="{{ ($index % $columns) * (100 / $columns) + (100 / $columns / 2) }}%" 
                    y1="{{ floor($index / $columns) * 33 + 16 }}%"
                    x2="{{ (($index + 1) % $columns) * (100 / $columns) + (100 / $columns / 2) }}%" 
                    y2="{{ floor(($index + 1) / $columns) * 33 + 16 }}%"
                    stroke="{{ $connectionColor }}"
                    stroke-width="1"
                    stroke-dasharray="4 4"
                    class="opacity-0 group-hover:opacity-100 transition-opacity"
                />
            @endif
        @endforeach
    </svg>

    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden rounded-xl">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="aspect-square w-full object-cover transition-all duration-500 group-hover:scale-105 group-hover:shadow-2xl"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
            
            {{-- Node point --}}
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3 h-3 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-lg shadow-blue-500/50"></div>
        </div>
    @endforeach
</div>
