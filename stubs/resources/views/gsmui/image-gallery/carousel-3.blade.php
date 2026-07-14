@props([
    'images' => [],
    'perspective' => '1000px',
    'rotateY' => 30,
    'gap' => '100px',
])

<div 
    {{ $attributes->class(["relative h-96 overflow-hidden"]) }}
    x-data="{ current: 0, total: {{ count($images) }}, rotation: {{ $rotateY }} }"
>
    <div 
        class="absolute inset-0 flex items-center justify-center"
        style="perspective: {{ $perspective }};"
    >
        <div 
            class="relative h-full w-64 transition-transform duration-700"
            :style="`transform: translateZ(-${{ $gap }}px) rotateY(${-current * rotation}deg)`"
        >
            @foreach($images as $index => $image)
                <div 
                    class="absolute inset-0 w-64 overflow-hidden rounded-2xl shadow-2xl"
                    :style="`transform: rotateY({{ $index }}deg) translateZ({{ $gap }}px);`"
                >
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? 'Card ' . ($index + 1) }}"
                        class="h-full w-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <p class="text-sm font-semibold text-white">{{ $image['title'] ?? 'Image ' . ($index + 1) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Controls --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-4">
        <button @click="current = (current - 1 + total) % total" class="rounded-full bg-white/90 p-3 shadow-lg hover:bg-white transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button @click="current = (current + 1) % total" class="rounded-full bg-white/90 p-3 shadow-lg hover:bg-white transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
    </div>
</div>
