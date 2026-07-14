@props([
    'images' => [],
    'blobSize' => '300px',
    'animationSpeed' => 8,
])

<div 
    {{ $attributes->class(["relative h-[500px] flex items-center justify-center"]) }}
    x-data="{ current: 0, total: {{ count($images) }} }"
    x-init="setInterval(() => current = (current + 1) % total, {{ $animationSpeed * 1000 }})"
>
    @foreach($images as $index => $image)
        <div 
            class="absolute transition-all duration-1000"
            :class="{ 'opacity-100 scale-100 z-10': current === {{ $index }}, 'opacity-0 scale-50 z-0': current !== {{ $index }} }"
            style="width: {{ $blobSize }}; height: {{ $blobSize }};"
        >
            <div class="w-full h-full overflow-hidden animate-morph">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover"
                />
            </div>
        </div>
    @endforeach

    <div class="absolute bottom-8 flex gap-2">
        @foreach($images as $index => $image)
            <button 
                @click="current = {{ $index }}"
                class="w-3 h-3 rounded-full transition-all duration-300"
                :class="current === {{ $index }} ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/60'"
            ></button>
        @endforeach
    </div>
</div>

<style>
@keyframes morph {
    0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
    25% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
    50% { border-radius: 50% 60% 30% 60% / 30% 40% 70% 60%; }
    75% { border-radius: 60% 30% 60% 40% / 70% 50% 40% 60%; }
}
.animate-morph {
    animation: morph {{ $animationSpeed }}s ease-in-out infinite;
}
</style>
