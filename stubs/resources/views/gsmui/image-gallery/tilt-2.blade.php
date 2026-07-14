@props([
    'images' => [],
    'columns' => 4,
    'gap' => 4,
    'shineColor' => 'rgba(255,255,255,0.4)',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-xl"
            x-data="{ tiltX: 0, tiltY: 0, shinePos: 0 }"
            @mousemove="
                const rect = $el.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                const y = (event.clientY - rect.top) / rect.height;
                tiltX = (y - 0.5) * 20;
                tiltY = (x - 0.5) * -20;
                shinePos = x * 100;
            "
            @mouseleave="tiltX = 0; tiltY = 0;"
            :style="`transform: perspective(800px) rotateX(${tiltX}deg) rotateY(${tiltY}deg); transform-style: preserve-3d;`"
        >
            <div class="aspect-square overflow-hidden rounded-xl">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover"
                />
            </div>
            <div 
                class="absolute inset-0 rounded-xl pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity"
                :style="`background: linear-gradient(105deg, transparent ${shinePos - 20}%, {{ $shineColor }} ${shinePos}%, transparent ${shinePos + 20}%);`"
            ></div>
            <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                <p class="text-sm font-medium text-white">{{ $image['title'] ?? 'Image' }}</p>
            </div>
        </div>
    @endforeach
</div>
