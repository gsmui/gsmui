@props([
    'images' => [],
    'columns' => 4,
    'gap' => 4,
    'tiltAmount' => 15,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-xl"
            x-data="{ tiltX: 0, tiltY: 0 }"
            @mousemove="
                const rect = $el.getBoundingClientRect();
                tiltX = ((event.clientX - rect.left) / rect.width - 0.5) * {{ $tiltAmount }};
                tiltY = ((event.clientY - rect.top) / rect.height - 0.5) * -{{ $tiltAmount }};
            "
            @mouseleave="tiltX = 0; tiltY = 0;"
            :style="`transform: perspective(1000px) rotateX(${tiltY}deg) rotateY(${tiltX}deg); transition: transform 0.3s ease-out;`"
        >
            <div class="aspect-square overflow-hidden">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-125"
                />
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                <div class="absolute bottom-4 left-4 right-4 transform translate-y-4 group-hover:translate-y-0 transition-transform">
                    <h3 class="font-bold text-white">{{ $image['title'] ?? 'Image' }}</h3>
                </div>
            </div>
            <div class="absolute inset-0 shadow-[inset_0_0_30px_rgba(0,0,0,0.3)] rounded-xl pointer-events-none"></div>
        </div>
    @endforeach
</div>
