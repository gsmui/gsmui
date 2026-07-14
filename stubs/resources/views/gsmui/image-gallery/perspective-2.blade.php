@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'flipAxis' => 'Y',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative h-72 cursor-pointer"
            style="perspective: 1000px;"
        >
            <div 
                class="relative w-full h-full transition-transform duration-700 transform-style-3d"
                :class="{ '{{ $flipAxis === "Y" ? "rotate-y-180" : "rotate-x-180" }}': fl{{ $index }} }"
                x-data="{ fl{{ $index }}: false }"
                @mouseenter="fl{{ $index }} = true"
                @mouseleave="fl{{ $index }} = false"
            >
                {{-- Front --}}
                <div class="absolute inset-0 backface-hidden rounded-2xl overflow-hidden">
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? '' }}"
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <h3 class="font-bold text-white">{{ $image['title'] ?? 'Image' }}</h3>
                    </div>
                </div>

                {{-- Back --}}
                <div class="absolute inset-0 backface-hidden rounded-2xl overflow-hidden bg-gradient-to-br from-blue-600 to-purple-700 p-6 flex flex-col justify-center text-white" style="transform: {{ $flipAxis === 'Y' ? 'rotateY(180deg)' : 'rotateX(180deg)' }};">
                    <h3 class="text-xl font-bold mb-2">{{ $image['title'] ?? 'Details' }}</h3>
                    <p class="text-sm opacity-80 mb-4">{{ $image['description'] ?? 'This image has additional details that appear on hover.' }}</p>
                    <button class="self-start rounded-full bg-white/20 px-4 py-2 text-sm font-medium hover:bg-white/30 transition-colors">
                        View Details →
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
.transform-style-3d { transform-style: preserve-3d; }
.backface-hidden { backface-visibility: hidden; }
.rotate-y-180 { transform: rotateY(180deg); }
.rotate-x-180 { transform: rotateX(180deg); }
</style>
