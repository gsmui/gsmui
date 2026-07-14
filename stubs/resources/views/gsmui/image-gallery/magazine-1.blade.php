@props([
    'images' => [],
    'featured' => null,
    'gap' => 4,
])

@php
    $featuredImage = $featured ?? $images[0] ?? null;
    $gridImages = $featured ? $images : array_slice($images, 1);
@endphp

<div {{ $attributes->class(["grid grid-cols-3 gap-{$gap}"]) }}>
    {{-- Featured Image --}}
    @if($featuredImage)
        <div class="col-span-2 row-span-2 group relative overflow-hidden rounded-2xl">
            <img 
                src="{{ $featuredImage['src'] ?? $featuredImage }}" 
                alt="{{ $featuredImage['alt'] ?? 'Featured' }}"
                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                style="min-height: 400px;"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent">
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="inline-block rounded-full bg-blue-500 px-3 py-1 text-xs font-semibold text-white mb-3">Featured</span>
                    <h2 class="text-2xl font-bold text-white mb-2">{{ $featuredImage['title'] ?? 'Featured Image' }}</h2>
                    <p class="text-white/70">{{ $featuredImage['description'] ?? '' }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Grid Images --}}
    @foreach($gridImages as $index => $image)
        <div class="group relative overflow-hidden rounded-xl">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? 'Image ' . ($index + 1) }}"
                class="aspect-square w-full object-cover transition-transform duration-500 group-hover:scale-110"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors"></div>
        </div>
    @endforeach
</div>
