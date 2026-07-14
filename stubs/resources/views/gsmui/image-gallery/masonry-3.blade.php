@props([
    'images' => [],
    'columns' => 3,
    'gap' => 3,
    'showOverlay' => true,
])

<div {{ $attributes->class(["columns-{$columns} gap-{$gap} space-y-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800 mb-{$gap}">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? 'Image ' . ($index + 1) }}"
                class="w-full object-cover transition-transform duration-700 group-hover:scale-105"
                style="{{ isset($image['height']) ? 'height: ' . $image['height'] : '' }}"
            />
            @if($showOverlay)
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/90 via-zinc-900/20 to-transparent">
                    <div class="absolute bottom-0 left-0 right-0 p-5 transform translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                        <span class="inline-block rounded-full bg-blue-500 px-3 py-1 text-xs font-semibold text-white mb-2">{{ $image['category'] ?? 'Category' }}</span>
                        <h3 class="text-lg font-bold text-white">{{ $image['title'] ?? 'Image Title' }}</h3>
                        <p class="mt-1 text-sm text-white/70">{{ $image['description'] ?? '' }}</p>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
