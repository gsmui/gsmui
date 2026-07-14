@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'hoverEffect' => 'zoom',
])

<div {{ $attributes->class(["columns-{$columns} gap-{$gap} space-y-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden rounded-xl break-inside-avoid {{ $hoverEffect === 'zoom' ? 'hover:scale-[1.02]' : '' }} transition-transform duration-300">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? 'Masonry image ' . ($index + 1) }}"
                class="w-full object-cover {{ $image['aspect'] ?? 'aspect-auto' }}"
                style="{{ isset($image['height']) ? 'height: ' . $image['height'] : '' }}"
            />
            @if(isset($image['title']))
                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <h4 class="font-semibold text-white">{{ $image['title'] }}</h4>
                    <p class="text-sm text-white/70">{{ $image['subtitle'] ?? '' }}</p>
                </div>
            @endif
        </div>
    @endforeach
</div>
