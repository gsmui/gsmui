@props([
    'images' => [],
    'layers' => 4,
    'offset' => 20,
])

<div {{ $attributes->class(["relative h-[500px] overflow-hidden bg-zinc-100 dark:bg-zinc-900"]) }}>
    @foreach($images as $index => $image)
        @if($index < $layers)
            <div 
                class="absolute rounded-2xl overflow-hidden shadow-2xl transition-all duration-700"
                style="
                    left: {{ 10 + ($index * 5) }}%;
                    top: {{ 10 + ($index * 8) }}%;
                    width: {{ 70 - ($index * 10) }}%;
                    height: {{ 70 - ($index * 8) }}%;
                    z-index: {{ $layers - $index }};
                "
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-black/{{ $index * 10 }}"></div>
            </div>
        @endif
    @endforeach

    <div class="absolute inset-0 flex items-center justify-center z-20">
        <div class="text-center bg-white/90 dark:bg-zinc-800/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl">
            <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">{{ $images[0]['title'] ?? 'Depth Layers' }}</h3>
            <p class="text-zinc-600 dark:text-zinc-400">{{ count($images) }} overlapping layers</p>
        </div>
    </div>
</div>
