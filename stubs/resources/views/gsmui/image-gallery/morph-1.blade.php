@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'morphSpeed' => 500,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-2xl"
            x-data="{ morphed: false }"
            @mouseenter="morphed = true"
            @mouseleave="morphed = false"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="aspect-square w-full object-cover transition-all duration-700"
                :class="{ 
                    'rounded-2xl': !morphed,
                    'rounded-[2rem_0.5rem_2rem_0.5rem]': morphed,
                    'scale-110': morphed,
                    'grayscale-0': !morphed,
                    'grayscale-[30%]': morphed
                }"
            />
            <div 
                class="absolute inset-0 bg-gradient-to-br from-purple-500/0 to-pink-500/0 transition-all duration-700"
                :class="{ 'from-purple-500/20 to-pink-500/20': morphed }"
            ></div>
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                <div class="bg-black/60 backdrop-blur-sm rounded-full px-4 py-2 text-white text-sm font-medium transform scale-75 group-hover:scale-100 transition-transform duration-300">
                    {{ $image['title'] ?? 'Explore' }}
                </div>
            </div>
        </div>
    @endforeach
</div>
