@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'rounded' => 'lg',
    'hover' => true,
])

<div {{ $attributes->class([
    "grid grid-cols-{$columns} gap-{$gap}",
]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden rounded-{{ $rounded }} bg-zinc-100 dark:bg-zinc-800 aspect-square">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? 'Gallery image ' . ($index + 1) }}"
                class="h-full w-full object-cover transition-transform duration-300 {{ $hover ? 'group-hover:scale-110' : '' }}"
            />
            @if(isset($image['caption']))
                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <p class="text-sm font-medium text-white">{{ $image['caption'] }}</p>
                </div>
            @endif
        </div>
    @endforeach
</div>
