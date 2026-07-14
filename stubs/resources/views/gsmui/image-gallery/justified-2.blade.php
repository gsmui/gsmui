@props([
    'images' => [],
    'rowHeight' => '250px',
    'overlap' => '-16px',
    'hoverScale' => true,
])

<div {{ $attributes->class(["flex flex-wrap"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-2xl {{ $index > 0 ? 'ml-4' : '' }}"
            style="flex: {{ $image['flex'] ?? '1 1 300px' }}; height: {{ $image['height'] ?? $rowHeight }}; margin-top: {{ $index % 2 === 0 ? '0' : $overlap }};"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="h-full w-full object-cover transition-all duration-700 {{ $hoverScale ? 'group-hover:scale-105 group-hover:brightness-110' : '' }}"
            />
            <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-2xl"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute bottom-4 left-4 right-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="text-lg font-bold text-white">{{ $image['title'] ?? 'Image' }}</h3>
                    <p class="text-sm text-white/70">{{ $image['subtitle'] ?? '' }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
