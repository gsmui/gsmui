@props([
    'images' => [],
    'columns' => 4,
    'gap' => 4,
    'fallDelay' => 100,
])

<div 
    {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}
    x-data="{ 
        fallen: false,
        reset() { this.fallen = false; }
    }"
    x-intersect.once="fallen = true"
>
    @foreach($images as $index => $image)
        <div 
            class="relative overflow-hidden rounded-xl aspect-square"
            :class="{ 'animate-fall': fallen }"
            :style="`
                animation-delay: {{ $index * $fallDelay }}ms;
                ${ fallen ? '' : 'opacity: 0; transform: translateY(-100px) rotate(' . rand(-15, 15) . 'deg);' }
            `"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-xl"></div>
        </div>
    @endforeach
</div>

<style>
@keyframes fall {
    0% { opacity: 0; transform: translateY(-100px) rotate(-15deg); }
    60% { opacity: 1; transform: translateY(10px) rotate(5deg); }
    80% { transform: translateY(-5px) rotate(-2deg); }
    100% { opacity: 1; transform: translateY(0) rotate(0deg); }
}
.animate-fall {
    animation: fall 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    opacity: 0;
}
</style>
