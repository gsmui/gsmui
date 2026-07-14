@props([
    'images' => [],
    'columns' => 4,
    'gap' => 2,
    'distortionAmount' => 20,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden aspect-square"
            x-data="{ hover: false, mouseX: 50, mouseY: 50 }"
            @mouseenter="hover = true"
            @mouseleave="hover = false"
            @mousemove="
                const rect = $el.getBoundingClientRect();
                mouseX = ((event.clientX - rect.left) / rect.width) * 100;
                mouseY = ((event.clientY - rect.top) / rect.height) * 100;
            "
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                :style="hover ? `filter: url(#liquid-${{ $index }});` : ''"
            />
            
            {{-- SVG Filter for liquid effect --}}
            <svg class="hidden">
                <defs>
                    <filter id="liquid-{{ $index }}">
                        <feTurbulence type="fractalNoise" baseFrequency="0.01" numOctaves="3" result="noise" seed="{{ $index }}" />
                        <feDisplacementMap in="SourceGraphic" in2="noise" scale="{{ $distortionAmount }}" xChannelSelector="R" yChannelSelector="G" />
                    </filter>
                </defs>
            </svg>

            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors duration-300"></div>
        </div>
    @endforeach
</div>
