@props([
    'images' => [],
    'columns' => 4,
    'gap' => 4,
    'embossAmount' => 5,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative">
            <div class="relative overflow-hidden rounded-xl bg-zinc-300 dark:bg-zinc-700 p-1">
                <div class="relative overflow-hidden rounded-lg">
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? '' }}"
                        class="aspect-square w-full object-cover transition-all duration-500 group-hover:scale-110"
                    />
                    {{-- Emboss effect layers --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-black/20 mix-blend-overlay"></div>
                    <div class="absolute inset-0 shadow-[inset_2px_2px_4px_rgba(255,255,255,0.3),inset_-2px_-2px_4px_rgba(0,0,0,0.3)]"></div>
                </div>
                {{-- Embossed border --}}
                <div class="absolute inset-0 rounded-xl shadow-[2px_2px_4px_rgba(0,0,0,0.3),-1px_-1px_2px_rgba(255,255,255,0.1)] pointer-events-none"></div>
            </div>
            <div class="absolute bottom-2 left-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <div class="bg-white/90 dark:bg-zinc-800/90 backdrop-blur-sm rounded-lg p-2 shadow-lg">
                    <p class="text-xs font-medium text-zinc-900 dark:text-white truncate">{{ $image['title'] ?? 'Image' }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
