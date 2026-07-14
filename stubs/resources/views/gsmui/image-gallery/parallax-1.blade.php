@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'depth' => 20,
])

<div 
    {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}
    x-data="{ mouseX: 0, mouseY: 0 }"
    @mousemove="mouseX = (event.clientX / window.innerWidth - 0.5) * 2; mouseY = (event.clientY / window.innerHeight - 0.5) * 2;"
>
    @foreach($images as $index => $image)
        @php
            $layer = ($index % 3) + 1;
            $depthMultiplier = $layer * 0.5;
        @endphp
        <div 
            class="group relative overflow-hidden rounded-2xl"
            :style="`transform: translate(${mouseX * {{ $depth }} * $depthMultiplier}px, ${mouseY * {{ $depth }} * $depthMultiplier}px); transition: transform 0.3s ease-out;`"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="aspect-square w-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors duration-300"></div>
            <div class="absolute inset-0 ring-1 ring-inset ring-white/10 rounded-2xl"></div>
        </div>
    @endforeach
</div>
