@props([
    'images' => [],
    'stackCount' => 5,
    'spread' => 12,
    'rotation' => 3,
])

<div 
    {{ $attributes->class(["relative h-96 flex items-center justify-center"]) }}
    x-data="{ 
        current: 0, 
        total: {{ count($images) }},
        next() { this.current = (this.current + 1) % this.total; },
        prev() { this.current = (this.current - 1 + this.total) % this.total; }
    }"
>
    @foreach($images as $index => $image)
        <div 
            class="absolute w-72 h-80 rounded-2xl overflow-hidden shadow-2xl transition-all duration-700 cursor-pointer"
            :class="{ 
                'z-30 scale-100': current === {{ $index }},
                'z-20 scale-95': current === ({{ $index }} + 1) % total,
                'z-10 scale-90': current === ({{ $index }} + 2) % total,
                'z-0 scale-85 opacity-50': true
            }"
            :style="`transform: rotate(${({{ $index }} - current) * $rotation}deg) translateX(${({{ $index }} - current) * $spread}px);`"
            @click="current = {{ $index }}"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-4 left-4 right-4">
                <p class="text-sm font-semibold text-white">{{ $image['title'] ?? 'Card ' . ($index + 1) }}</p>
            </div>
        </div>
    @endforeach

    <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 flex gap-2">
        <button @click="prev()" class="rounded-full bg-white dark:bg-zinc-800 p-2 shadow-lg hover:scale-110 transition-transform">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button @click="next()" class="rounded-full bg-white dark:bg-zinc-800 p-2 shadow-lg hover:scale-110 transition-transform">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
    </div>
</div>
