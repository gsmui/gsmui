@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'glare' => true,
    'maxTilt' => 25,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-2xl"
            x-data="{ tiltX: 0, tiltY: 0, glareX: 50, glareY: 50 }"
            @mousemove="
                const rect = $el.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                const y = (event.clientY - rect.top) / rect.height;
                tiltX = (y - 0.5) * {{ $maxTilt }};
                tiltY = (x - 0.5) * -{{ $maxTilt }};
                glareX = x * 100;
                glareY = y * 100;
            "
            @mouseleave="tiltX = 0; tiltY = 0;"
            :style="`transform: perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale3d(1.05, 1.05, 1.05); transition: transform 0.3s ease-out;`"
        >
            <div class="aspect-square overflow-hidden">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                />
            </div>
            @if($glare)
                <div 
                    class="absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    :style="`background: radial-gradient(circle at ${glareX}% ${glareY}%, rgba(255,255,255,0.3) 0%, transparent 60%);`"
                ></div>
            @endif
            <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-2xl pointer-events-none"></div>
        </div>
    @endforeach
</div>
