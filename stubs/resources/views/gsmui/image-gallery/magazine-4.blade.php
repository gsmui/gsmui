@props([
    'images' => [],
    'sectionTitle' => 'Gallery',
    'itemWidth' => '300px',
    'gap' => 4,
])

<div {{ $attributes->class(["space-y-6"]) }}>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $sectionTitle }}</h2>
        <button class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">View All →</button>
    </div>
    
    <div class="flex gap-{{ $gap }} overflow-x-auto pb-4 scrollbar-hide snap-x snap-mandatory">
        @foreach($images as $index => $image)
            <div class="shrink-0 snap-start group" style="width: {{ $itemWidth }};">
                <div class="overflow-hidden rounded-xl">
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? '' }}"
                        class="h-48 w-full object-cover transition-transform duration-500 group-hover:scale-110"
                    />
                </div>
                <div class="mt-3">
                    <h4 class="font-semibold text-zinc-900 dark:text-white group-hover:text-blue-600 transition-colors">{{ $image['title'] ?? 'Image' }}</h4>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $image['description'] ?? '' }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
