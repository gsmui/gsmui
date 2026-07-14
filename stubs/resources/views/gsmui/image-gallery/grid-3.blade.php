@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'shadow' => true,
    'border' => false,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden rounded-xl {{ $shadow ? 'shadow-lg hover:shadow-2xl' : '' }} {{ $border ? 'border-2 border-zinc-200 dark:border-zinc-700' : '' }} transition-shadow duration-300">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? 'Image ' . ($index + 1) }}"
                class="aspect-[4/3] w-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                <div class="absolute bottom-4 left-4 right-4">
                    <h3 class="text-lg font-bold text-white">{{ $image['title'] ?? 'Image ' . ($index + 1) }}</h3>
                    <p class="text-sm text-white/80">{{ $image['description'] ?? '' }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
