@props([
    'images' => [],
    'columns' => 4,
    'gap' => 2,
    'overlayColor' => 'blue',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden rounded-md aspect-square">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? 'Gallery ' . ($index + 1) }}"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-125"
            />
            <div class="absolute inset-0 bg-{{ $overlayColor }}-500/80 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                <div class="text-center text-white">
                    <svg class="mx-auto h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </div>
            </div>
        </div>
    @endforeach
</div>
