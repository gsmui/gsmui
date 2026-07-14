@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'showInfo' => true,
])

<div 
    {{ $attributes }}
    x-data="{ 
        open: false, 
        current: 0,
        openImage(index) { this.current = index; this.open = true; },
        close() { this.open = false; },
        next() { this.current = (this.current + 1) % {{ count($images) }}; },
        prev() { this.current = (this.current - 1 + {{ count($images) }}) % {{ count($images) }}; }
    }"
>
    <div class="grid grid-cols-{{ $columns }} gap-{{ $gap }}">
        @foreach($images as $index => $image)
            <div @click="openImage({{ $index }})" class="group cursor-pointer relative rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="aspect-[4/3] w-full object-cover"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="absolute bottom-4 left-4 right-4">
                        <h3 class="font-bold text-white">{{ $image['title'] ?? 'Image' }}</h3>
                        <p class="text-sm text-white/70">{{ $image['author'] ?? '' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Lightbox with Info Panel --}}
    <template x-if="open">
        <div class="fixed inset-0 z-50 flex">
            <div class="flex-1 bg-black/90 flex items-center justify-center" @click.self="close()">
                <button @click="close()" class="absolute top-4 left-4 text-white/80 hover:text-white">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <button @click="prev()" class="absolute left-4 text-white/80 hover:text-white">
                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="next()" class="absolute right-[340px] text-white/80 hover:text-white">
                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                @foreach($images as $index => $image)
                    <img 
                        x-show="current === {{ $index }}"
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? '' }}"
                        class="max-h-[90vh] max-w-[65vw] object-contain"
                    />
                @endforeach
            </div>

            @if($showInfo)
                <div class="w-80 bg-zinc-900 p-6 overflow-y-auto">
                    @foreach($images as $index => $image)
                        <div x-show="current === {{ $index }}">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $image['title'] ?? 'Image ' . ($index + 1) }}</h3>
                            <p class="text-sm text-zinc-400 mb-4">{{ $image['description'] ?? '' }}</p>
                            <div class="space-y-2 text-sm">
                                @if(isset($image['author']))
                                    <div class="flex justify-between"><span class="text-zinc-500">Author</span><span class="text-white">{{ $image['author'] }}</span></div>
                                @endif
                                @if(isset($image['date']))
                                    <div class="flex justify-between"><span class="text-zinc-500">Date</span><span class="text-white">{{ $image['date'] }}</span></div>
                                @endif
                                @if(isset($image['dimensions']))
                                    <div class="flex justify-between"><span class="text-zinc-500">Size</span><span class="text-white">{{ $image['dimensions'] }}</span></div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </template>
</div>
