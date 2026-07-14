@props([
    'images' => [],
    'columns' => 4,
    'gap' => 4,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer"
            x-data="{ hovered: false }"
            @mouseenter="hovered = true"
            @mouseleave="hovered = false"
        >
            {{-- Top half --}}
            <div 
                class="absolute top-0 left-0 right-0 h-1/2 overflow-hidden origin-bottom transition-transform duration-500"
                :class="{ 'rotate-x-90': hovered }"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-200% object-cover"
                    style="object-position: top;"
                />
            </div>

            {{-- Bottom half --}}
            <div 
                class="absolute bottom-0 left-0 right-0 h-1/2 overflow-hidden origin-top transition-transform duration-500"
                :class="{ '-rotate-x-90': hovered }"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-200% object-cover"
                    style="object-position: bottom; margin-top: -100%;"
                />
            </div>

            {{-- Overlay on hover --}}
            <div 
                class="absolute inset-0 bg-blue-600/90 flex items-center justify-center transition-opacity duration-300"
                :class="{ 'opacity-0': !hovered, 'opacity-100': hovered }"
            >
                <div class="text-center text-white transform transition-transform duration-300" :class="{ 'scale-100': hovered, 'scale-75': !hovered }">
                    <svg class="h-10 w-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                    <p class="font-semibold">{{ $image['title'] ?? 'View' }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
.h-200\% { height: 200%; }
.rotate-x-90 { transform: rotateX(90deg); }
.-rotate-x-90 { transform: rotateX(-90deg); }
</style>
