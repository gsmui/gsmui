@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'showClose' => true,
    'showCounter' => true,
])

<div 
    {{ $attributes->class([""]) }}
    x-data="{ 
        open: false, 
        currentIndex: 0,
        openImage(index) { this.currentIndex = index; this.open = true; document.body.style.overflow = 'hidden'; },
        close() { this.open = false; document.body.style.overflow = ''; },
        next() { this.currentIndex = (this.currentIndex + 1) % {{ count($images) }}; },
        prev() { this.currentIndex = (this.currentIndex - 1 + {{ count($images) }}) % {{ count($images) }}; }
    }"
    @keydown.escape.window="close()"
    @keydown.arrow-right.window="open && next()"
    @keydown.arrow-left.window="open && prev()"
>
    {{-- Gallery Grid --}}
    <div class="grid grid-cols-{{ $columns }} gap-{{ $gap }}">
        @foreach($images as $index => $image)
            <div 
                class="group cursor-pointer overflow-hidden rounded-xl"
                @click="openImage({{ $index }})"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? 'Gallery ' . ($index + 1) }}"
                    class="aspect-square w-full object-cover transition-transform duration-300 group-hover:scale-110"
                />
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <div class="rounded-full bg-white/90 p-3">
                        <svg class="h-6 w-6 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Lightbox Overlay --}}
    <template x-if="open">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/95" @click.self="close()">
            {{-- Close Button --}}
            @if($showClose)
                <button @click="close()" class="absolute top-6 right-6 rounded-full bg-white/10 p-2 text-white hover:bg-white/20 transition-colors z-10">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif

            {{-- Navigation --}}
            <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white hover:bg-white/20 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white hover:bg-white/20 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Image --}}
            @foreach($images as $index => $image)
                <img 
                    x-show="currentIndex === {{ $index }}"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? 'Image ' . ($index + 1) }}"
                    class="max-h-[85vh] max-w-[90vw] object-contain"
                />
            @endforeach

            {{-- Counter --}}
            @if($showCounter)
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 rounded-full bg-white/10 px-4 py-2 text-sm text-white backdrop-blur-sm">
                    <span x-text="currentIndex + 1"></span> / {{ count($images) }}
                </div>
            @endif
        </div>
    </template>
</div>
