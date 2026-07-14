@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'flipDirection' => 'horizontal',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative h-80 cursor-pointer"
            style="perspective: 1000px;"
            x-data="{ flipped: false }"
            @click="flipped = !flipped"
        >
            <div 
                class="relative w-full h-full transition-transform duration-700"
                :class="{ '{{ $flipDirection === "horizontal" ? "rotate-y-180" : "rotate-x-180" }}': flipped }"
                style="transform-style: preserve-3d;"
            >
                {{-- Front --}}
                <div class="absolute inset-0 backface-hidden rounded-2xl overflow-hidden">
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? '' }}"
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <h3 class="font-bold text-white text-lg">{{ $image['title'] ?? 'Image' }}</h3>
                        <p class="text-sm text-white/70">Click to flip</p>
                    </div>
                </div>

                {{-- Back --}}
                <div 
                    class="absolute inset-0 backface-hidden rounded-2xl overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-700 p-6 flex flex-col justify-between text-white"
                    style="{{ $flipDirection === 'horizontal' ? 'transform: rotateY(180deg);' : 'transform: rotateX(180deg);' }}"
                >
                    <div>
                        <h3 class="text-xl font-bold mb-2">{{ $image['title'] ?? 'Details' }}</h3>
                        <p class="text-sm opacity-80">{{ $image['description'] ?? 'This is additional information about the image that appears on the back of the card.' }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs opacity-60">{{ $image['date'] ?? '2024' }}</span>
                        <button class="rounded-full bg-white/20 px-4 py-2 text-sm hover:bg-white/30 transition-colors">
                            View More →
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
.backface-hidden { backface-visibility: hidden; }
.rotate-y-180 { transform: rotateY(180deg); }
.rotate-x-180 { transform: rotateX(180deg); }
</style>
