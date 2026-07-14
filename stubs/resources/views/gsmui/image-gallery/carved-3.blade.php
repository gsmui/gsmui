@props([
    'images' => [],
    'columns' => 3,
    'gap' => 8,
    'frameWidth' => '12px',
    'frameColor' => 'zinc-800',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative">
            {{-- Ornate frame --}}
            <div class="p-{{ $frameWidth }} bg-{{ $frameColor }} rounded-2xl shadow-2xl">
                <div class="relative overflow-hidden rounded-xl">
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? '' }}"
                        class="aspect-[4/5] w-full object-cover transition-all duration-700 group-hover:scale-105"
                    />
                    {{-- Inner shadow for carved depth --}}
                    <div class="absolute inset-0 shadow-[inset_0_0_30px_rgba(0,0,0,0.4)]"></div>
                    {{-- Corner ornaments --}}
                    <div class="absolute top-2 left-2 w-6 h-6 border-t-2 border-l-2 border-white/30 rounded-tl-lg"></div>
                    <div class="absolute top-2 right-2 w-6 h-6 border-t-2 border-r-2 border-white/30 rounded-tr-lg"></div>
                    <div class="absolute bottom-2 left-2 w-6 h-6 border-b-2 border-l-2 border-white/30 rounded-bl-lg"></div>
                    <div class="absolute bottom-2 right-2 w-6 h-6 border-b-2 border-r-2 border-white/30 rounded-br-lg"></div>
                </div>
            </div>
            <div class="mt-3 text-center">
                <h4 class="font-serif text-lg font-semibold text-zinc-900 dark:text-white">{{ $image['title'] ?? 'Portrait' }}</h4>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $image['artist'] ?? '' }}</p>
            </div>
        </div>
    @endforeach
</div>
