@props([
    'images' => [],
    'offset' => 60,
    'scale' => 0.9,
])

<div 
    {{ $attributes->class(["relative h-80 overflow-hidden"]) }}
    x-data="{ current: 0, total: {{ count($images) }} }"
>
    @foreach($images as $index => $image)
        <div 
            class="absolute left-1/2 top-1/2 w-64 h-72 -translate-x-1/2 -translate-y-1/2 rounded-xl overflow-hidden shadow-xl transition-all duration-500"
            :class="{ 
                'z-10 opacity-100': current === {{ $index }},
                'opacity-60': current !== {{ $index }}
            }"
            :style="`transform: translateX(calc(-50% + ${(current - {{ $index }}) * $offset}px)) translateY(-50%) scale(${current === {{ $index }} ? 1 : pow($scale, Math.abs(current - {{ $index }}))}); z-index: ${10 - Math.abs(current - {{ $index }})};`"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover"
            />
        </div>
    @endforeach

    <div class="absolute bottom-0 left-0 right-0 flex justify-center pb-4">
        @foreach($images as $index => $image)
            <button 
                @click="current = {{ $index }}"
                class="h-2 rounded-full mx-1 transition-all duration-300"
                :class="current === {{ $index }} ? 'w-8 bg-blue-500' : 'w-2 bg-zinc-300 dark:bg-zinc-600'"
            ></button>
        @endforeach
    </div>
</div>
