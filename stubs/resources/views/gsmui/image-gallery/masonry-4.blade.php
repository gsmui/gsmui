@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'imageHeight' => 'auto',
])

<div {{ $attributes->class(["columns-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative mb-{$gap} overflow-hidden rounded-2xl">
            <div class="relative overflow-hidden">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? 'Gallery ' . ($index + 1) }}"
                    class="w-full object-cover transition-all duration-500 group-hover:rotate-1 group-hover:scale-110"
                    style="height: {{ $imageHeight }}; {{ isset($image['height']) ? 'height: ' . $image['height'] : '' }}"
                />
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/70 to-transparent">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-white">{{ $image['title'] ?? 'Image' }}</h4>
                        <p class="text-xs text-white/60">{{ $image['date'] ?? '' }}</p>
                    </div>
                    <div class="flex items-center gap-1 text-white/80">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="text-xs">{{ $image['likes'] ?? '0' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
