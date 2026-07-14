@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
])

<div 
    {{ $attributes }}
    x-data="{ 
        open: false, 
        current: 0,
        fullscreen: false,
        openImage(index) { this.current = index; this.open = true; },
        close() { this.open = false; this.fullscreen = false; },
        next() { this.current = (this.current + 1) % {{ count($images) }}; },
        prev() { this.current = (this.current - 1 + {{ count($images) }}) % {{ count($images) }}; },
        toggleFullscreen() { this.fullscreen = !this.fullscreen; }
    }"
    @keydown.escape.window="open && close()"
    @keydown.arrow-right.window="open && next()"
    @keydown.arrow-left.window="open && prev()"
    @keydown.f.window="open && toggleFullscreen()"
>
    <div class="grid grid-cols-{{ $columns }} gap-{{ $gap }}">
        @foreach($images as $index => $image)
            <button @click="openImage({{ $index }})" class="group relative rounded-xl overflow-hidden aspect-square">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                />
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                    <svg class="h-10 w-10 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </div>
            </button>
        @endforeach
    </div>

    <template x-if="open">
        <div 
            class="fixed inset-0 z-50 bg-black flex items-center justify-center"
            :class="{ 'bg-black': !fullscreen, 'bg-black': fullscreen }"
        >
            <div class="absolute top-4 right-4 flex items-center gap-2 z-10">
                <button @click="toggleFullscreen()" class="rounded-full bg-white/10 p-2 text-white hover:bg-white/20">
                    <svg x-show="!fullscreen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <svg x-show="fullscreen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                    </svg>
                </button>
                <button @click="close()" class="rounded-full bg-white/10 p-2 text-white hover:bg-white/20">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white hover:bg-white/20">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white hover:bg-white/20">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            @foreach($images as $index => $image)
                <img 
                    x-show="current === {{ $index }}"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="max-h-[90vh] max-w-[90vw] object-contain"
                />
            @endforeach

            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-4">
                <span class="text-sm text-white/70">
                    <span x-text="current + 1"></span> / {{ count($images) }}
                </span>
                @if(isset($images[0]['title']))
                    <span class="text-sm text-white font-medium" x-text="$el.parentElement.querySelector('[x-show]')?.alt"></span>
                @endif
            </div>
        </div>
    </template>
</div>
