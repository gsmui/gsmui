@props([
    'images' => [],
    'columns' => 3,
    'gap' => 8,
    'shadowBlur' => 40,
    'shadowColor' => 'rgba(0,0,0,0.3)',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-800"
            x-data="{ tiltX: 0, tiltY: 0, shadowX: 0, shadowY: 0 }"
            @mousemove="
                const rect = $el.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width - 0.5;
                const y = (event.clientY - rect.top) / rect.height - 0.5;
                tiltX = y * -30;
                tiltY = x * 30;
                shadowX = x * -30;
                shadowY = y * 30;
            "
            @mouseleave="tiltX = 0; tiltY = 0; shadowX = 0; shadowY = 0;"
            :style="`
                transform: perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg);
                box-shadow: ${shadowX}px ${shadowY}px {{ $shadowBlur }}px {{ $shadowColor }};
                transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
            `"
        >
            <div class="aspect-square overflow-hidden">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover"
                />
            </div>
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors rounded-2xl"></div>
        </div>
    @endforeach
</div>
