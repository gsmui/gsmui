@props([
    'images' => [],
    'gap' => 2,
    'textOverlay' => true,
])

<div {{ $attributes->class(["grid grid-cols-4 grid-rows-3 gap-{$gap} h-[700px]"]) }}>
    @foreach($images as $index => $image)
        @php
            $spans = [
                'col-span-2 row-span-2', // Large
                'col-span-1 row-span-1', // Small
                'col-span-1 row-span-1', // Small
                'col-span-1 row-span-2', // Tall
                'col-span-1 row-span-1', // Small
                'col-span-2 row-span-1', // Wide
            ];
            $span = $spans[$index % count($spans)];
        @endphp
        <div class="{{ $span }} group relative overflow-hidden rounded-lg">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            @if($textOverlay)
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4">
                        @if(isset($image['tag']))
                            <span class="inline-block rounded bg-white/20 px-2 py-1 text-xs text-white backdrop-blur-sm mb-2">{{ $image['tag'] }}</span>
                        @endif
                        <h3 class="font-bold text-white text-lg leading-tight">{{ $image['title'] ?? '' }}</h3>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
