@props([
    'images' => [],
    'columns' => 4,
    'gap' => 3,
    'showNumbers' => true,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden rounded-lg aspect-square bg-zinc-200 dark:bg-zinc-800">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? 'Gallery image' }}"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
            />
            @if($showNumbers)
                <div class="absolute top-2 left-2 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-xs font-bold text-zinc-900 shadow-md">
                    {{ $index + 1 }}
                </div>
            @endif
            <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-lg"></div>
        </div>
    @endforeach
</div>
