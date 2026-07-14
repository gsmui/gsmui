@props([
    'images' => [],
    'gap' => 2,
    'borderRadius' => 'rounded-xl',
])

<div {{ $attributes->class(["grid grid-cols-4 grid-rows-4 gap-{$gap} h-[500px]"]) }}>
    @foreach($images as $index => $image)
        @php
            $puzzlePieces = [
                'col-span-2 row-span-1', // Wide top
                'col-span-1 row-span-2', // Tall left
                'col-span-1 row-span-1', // Small
                'col-span-1 row-span-1', // Small
                'col-span-1 row-span-1', // Small
                'col-span-2 row-span-2', // Large center
                'col-span-1 row-span-1', // Small
                'col-span-1 row-span-1', // Small
            ];
            $piece = $puzzlePieces[$index % count($puzzlePieces)];
        @endphp
        <div class="{{ $piece }} group relative overflow-hidden {{ $borderRadius }}">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="h-full w-full object-cover transition-all duration-500 group-hover:scale-110 group-hover:z-10"
            />
            <div class="absolute inset-0 ring-1 ring-inset ring-black/5 {{ $borderRadius }}"></div>
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                <div class="rounded-full bg-white/90 p-3 transform scale-50 group-hover:scale-100 transition-transform duration-300">
                    <svg class="h-5 w-5 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </div>
            </div>
        </div>
    @endforeach
</div>
