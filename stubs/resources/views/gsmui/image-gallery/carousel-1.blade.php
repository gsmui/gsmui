@props([
    'images' => [],
    'autoplay' => false,
    'interval' => 5000,
    'showDots' => true,
    'showArrows' => true,
    'height' => 'h-96',
])

<div 
    {{ $attributes->class(["relative overflow-hidden rounded-2xl bg-zinc-100 dark:bg-zinc-800"]) }}
    x-data="{ 
        current: 0, 
        total: {{ count($images) }},
        next() { this.current = (this.current + 1) % this.total; },
        prev() { this.current = (this.current - 1 + this.total) % this.total; }
    }"
    {{ $autoplay ? "x-init=\"setInterval(() => next(), $interval)\"" : '' }}
>
    <div class="relative {{ $height }}">
        @foreach($images as $index => $image)
            <div 
                class="absolute inset-0 transition-opacity duration-500"
                :class="{ 'opacity-100': current === {{ $index }}, 'opacity-0 pointer-events-none': current !== {{ $index }} }"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? 'Slide ' . ($index + 1) }}"
                    class="h-full w-full object-cover"
                />
                @if(isset($image['caption']))
                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                        <h3 class="text-xl font-bold text-white">{{ $image['caption'] }}</h3>
                        <p class="text-sm text-white/80">{{ $image['description'] ?? '' }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    @if($showArrows && count($images) > 1)
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-white/90 p-2 shadow-lg hover:bg-white transition-colors">
            <svg class="h-5 w-5 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-white/90 p-2 shadow-lg hover:bg-white transition-colors">
            <svg class="h-5 w-5 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    @endif

    @if($showDots && count($images) > 1)
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
            @foreach($images as $index => $image)
                <button 
                    @click="current = {{ $index }}"
                    class="h-2 w-2 rounded-full transition-colors"
                    :class="{ 'bg-white': current === {{ $index }}, 'bg-white/50': current !== {{ $index }} }"
                ></button>
            @endforeach
        </div>
    @endif
</div>
