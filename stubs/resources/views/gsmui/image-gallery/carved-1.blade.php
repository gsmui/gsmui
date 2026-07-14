@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'carveDepth' => 3,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden rounded-2xl bg-zinc-200 dark:bg-zinc-800 shadow-inner">
            <div class="relative">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="aspect-square w-full object-cover transition-all duration-700 group-hover:scale-105"
                />
                {{-- Carved border effect --}}
                <div class="absolute inset-0 shadow-[inset_0_4px_8px_rgba(0,0,0,0.3),inset_0_-2px_4px_rgba(255,255,255,0.1)]"></div>
                {{-- Texture overlay --}}
                <div class="absolute inset-0 opacity-20 mix-blend-overlay bg-gradient-to-br from-white/30 via-transparent to-black/30"></div>
            </div>
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-100 scale-75">
                    <div class="bg-zinc-900/80 backdrop-blur-sm rounded-lg px-4 py-2 text-white text-sm font-medium shadow-xl border border-zinc-700">
                        {{ $image['title'] ?? 'View' }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
