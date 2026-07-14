@props([
    'images' => [],
    'showThumbs' => true,
    'height' => 'h-[500px]',
    'thumbHeight' => 'h-20',
])

<div 
    {{ $attributes->class(["space-y-4"]) }}
    x-data="{ current: 0, total: {{ count($images) }} }"
>
    {{-- Main Image --}}
    <div class="relative {{ $height }} overflow-hidden rounded-2xl bg-zinc-900">
        @foreach($images as $index => $image)
            <div 
                class="absolute inset-0 transition-transform duration-500 ease-out"
                :class="{ 
                    'translate-x-0 opacity-100': current === {{ $index }}, 
                    '-translate-x-full opacity-0': current > {{ $index }}, 
                    'translate-x-full opacity-0': current < {{ $index }} 
                }"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? 'Image ' . ($index + 1) }}"
                    class="h-full w-full object-contain"
                />
            </div>
        @endforeach
        
        {{-- Image Counter --}}
        <div class="absolute top-4 right-4 rounded-full bg-black/60 px-3 py-1 text-sm text-white backdrop-blur-sm">
            <span x-text="current + 1"></span> / {{ count($images) }}
        </div>
    </div>

    {{-- Thumbnails --}}
    @if($showThumbs && count($images) > 1)
        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
            @foreach($images as $index => $image)
                <button 
                    @click="current = {{ $index }}"
                    class="shrink-0 {{ $thumbHeight }} w-24 overflow-hidden rounded-lg border-2 transition-all"
                    :class="{ 'border-blue-500 ring-2 ring-blue-500/30': current === {{ $index }}, 'border-transparent opacity-60 hover:opacity-100': current !== {{ $index }} }"
                >
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="Thumb {{ $index + 1 }}"
                        class="h-full w-full object-cover"
                    />
                </button>
            @endforeach
        </div>
    @endif
</div>
