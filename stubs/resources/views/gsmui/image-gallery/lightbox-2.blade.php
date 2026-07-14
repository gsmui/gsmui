@props([
    'images' => [],
    'columns' => 4,
    'gap' => 2,
    'rounded' => 'lg',
])

<div 
    {{ $attributes->class([""]) }}
    x-data="{ 
        open: false, 
        current: 0,
        startX: 0,
        openImage(index) { this.current = index; this.open = true; },
        close() { this.open = false; },
        next() { this.current = (this.current + 1) % {{ count($images) }}; },
        prev() { this.current = (this.current - 1 + {{ count($images) }}) % {{ count($images) }}; },
        handleStart(e) { this.startX = e.touches[0].clientX; },
        handleEnd(e) {
            const diff = this.startX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) { diff > 0 ? this.next() : this.prev(); }
        }
    }"
>
    {{-- Grid --}}
    <div class="grid grid-cols-{{ $columns }} gap-{{ $gap }}">
        @foreach($images as $index => $image)
            <button @click="openImage({{ $index }})" class="group relative overflow-hidden rounded-{{ $rounded }}">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="aspect-square w-full object-cover transition-transform duration-500 group-hover:scale-110"
                />
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                    <div class="opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </div>
                </div>
            </button>
        @endforeach
    </div>

    {{-- Lightbox --}}
    <template x-if="open">
        <div 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black"
            @click.self="close()"
            @touchstart="handleStart($event)"
            @touchend="handleEnd($event)"
        >
            <button @click="close()" class="absolute top-4 right-4 z-10 text-white/80 hover:text-white">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <button @click="prev()" class="absolute left-4 z-10 text-white/80 hover:text-white">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="next()" class="absolute right-4 z-10 text-white/80 hover:text-white">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            @foreach($images as $index => $image)
                <img 
                    x-show="current === {{ $index }}"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="max-h-screen max-w-full object-contain"
                />
            @endforeach

            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-1">
                @foreach($images as $index => $image)
                    <button 
                        @click="current = {{ $index }}"
                        class="h-1 rounded-full transition-all"
                        :class="current === {{ $index }} ? 'w-6 bg-white' : 'w-1 bg-white/40'"
                    ></button>
                @endforeach
            </div>
        </div>
    </template>
</div>
