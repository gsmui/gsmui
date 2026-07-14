@props([
    'images' => [],
    'columns' => 4,
    'gap' => 4,
    'rippleColor' => 'rgba(59, 130, 246, 0.4)',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-xl aspect-square"
            x-data="{ ripples: [] }"
            @click="
                const rect = $el.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                ripples.push({ x, y, id: Date.now() });
                setTimeout(() => ripples.shift(), 1000);
            "
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
            />

            {{-- Ripple effects --}}
            <template x-for="ripple in ripples" :key="ripple.id">
                <div 
                    class="absolute rounded-full animate-ripple pointer-events-none"
                    :style="`
                        left: ${ripple.x}px;
                        top: ${ripple.y}px;
                        width: 0;
                        height: 0;
                        background: {{ $rippleColor }};
                    `"
                ></div>
            </template>

            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
        </div>
    @endforeach
</div>

<style>
@keyframes ripple {
    0% { transform: translate(-50%, -50%) scale(0); opacity: 1; }
    100% { transform: translate(-50%, -50%) scale(20); opacity: 0; }
}
.animate-ripple {
    animation: ripple 1s ease-out forwards;
}
</style>
