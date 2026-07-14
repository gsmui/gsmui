@props([
    'images' => [],
    'size' => '180px',
    'gap' => '16px',
    'hoverEffect' => 'glow',
])

<div {{ $attributes->class(["flex flex-wrap justify-center items-center py-8"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative m-2 transform rotate-45"
            style="width: {{ $size }}; height: {{ $size }};"
        >
            <div class="absolute inset-0 overflow-hidden {{ $hoverEffect === 'glow' ? 'group-hover:shadow-[0_0_30px_rgba(59,130,246,0.5)]' : '' }} rounded-lg transition-shadow duration-300">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="h-full w-full object-cover -rotate-45 scale-150 transition-transform duration-700 group-hover:scale-[1.65]"
                />
            </div>
            <div class="absolute inset-0 -rotate-45 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="bg-black/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">{{ $image['label'] ?? 'View' }}</span>
            </div>
        </div>
    @endforeach
</div>
