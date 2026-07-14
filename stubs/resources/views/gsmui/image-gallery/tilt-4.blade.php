@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'glowColor' => 'blue',
    'glowIntensity' => 20,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        @php
            $colors = ['blue' => '59,130,246', 'purple' => '168,85,247', 'pink' => '236,72,153', 'cyan' => '6,182,212'];
            $rgb = $colors[$glowColor] ?? $colors['blue'];
        @endphp
        <div 
            class="group relative overflow-hidden rounded-2xl"
            x-data="{ tiltX: 0, tiltY: 0 }"
            @mousemove="
                const rect = $el.getBoundingClientRect();
                tiltX = ((event.clientY - rect.top) / rect.height - 0.5) * -20;
                tiltY = ((event.clientX - rect.left) / rect.width - 0.5) * 20;
            "
            @mouseleave="tiltX = 0; tiltY = 0;"
            :style="`transform: perspective(800px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale(1.02);`"
        >
            <div class="aspect-square overflow-hidden rounded-2xl">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
            </div>
            <div 
                class="absolute -inset-1 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10"
                :style="`background: linear-gradient(135deg, rgba({{ $rgb }}, 0.5), rgba({{ $rgb }}, 0.2)); filter: blur({{ $glowIntensity }}px);`"
            ></div>
            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-white/10 pointer-events-none"></div>
        </div>
    @endforeach
</div>
