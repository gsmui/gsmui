@props([
    'images' => [],
    'transitionDuration' => 1000,
    'shapes' => ['circle', 'hexagon', 'diamond', 'blob'],
])

<div 
    {{ $attributes->class(["relative h-[400px] overflow-hidden"]) }}
    x-data="{ 
        current: 0, 
        total: {{ count($images) }},
        transitioning: false,
        shapes: {{ json_encode($shapes) }}
    }"
    x-init="setInterval(() => { transitioning = true; setTimeout(() => { current = (current + 1) % total; transitioning = false; }, {{ $transitionDuration / 2 }}); }, 4000)"
>
    @foreach($images as $index => $image)
        <div 
            class="absolute inset-0 flex items-center justify-center transition-all"
            :class="{ 
                'opacity-100 scale-100': current === {{ $index }} && !transitioning,
                'opacity-0 scale-90': current !== {{ $index }} || transitioning
            }"
            style="transition-duration: {{ $transitionDuration }}ms;"
        >
            <div 
                class="w-64 h-64 overflow-hidden transition-all duration-1000"
                :class="{ 
                    'rounded-full': shapes[current % shapes.length] === 'circle',
                    'rounded-3xl rotate-[30deg]': shapes[current % shapes.length] === 'hexagon',
                    'rounded-lg rotate-45 scale-[0.7]': shapes[current % shapes.length] === 'diamond',
                    'animate-morph-blob': shapes[current % shapes.length] === 'blob'
                }"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover"
                />
            </div>
        </div>
    @endforeach

    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-3">
        @foreach($images as $index => $image)
            <button 
                @click="current = {{ $index }}"
                class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                :class="current === {{ $index }} ? 'bg-white w-8' : 'bg-white/40'"
            ></button>
        @endforeach
    </div>
</div>

<style>
@keyframes morph-blob {
    0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
    50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
}
.animate-morph-blob { animation: morph-blob 4s ease-in-out infinite; }
</style>
