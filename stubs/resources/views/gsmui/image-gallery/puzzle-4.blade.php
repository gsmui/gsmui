@props([
    'images' => [],
    'mainSize' => '300px',
    'smallSize' => '150px',
])

<div {{ $attributes->class(["relative flex items-center justify-center min-h-[400px]"]) }}>
    {{-- Center Image --}}
    @if(isset($images[0]))
        <div class="relative z-10 w-64 h-64 rounded-full overflow-hidden border-4 border-white dark:border-zinc-800 shadow-2xl group">
            <img 
                src="{{ $images[0]['src'] ?? $images[0] }}" 
                alt="{{ $images[0]['alt'] ?? 'Center' }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors rounded-full"></div>
        </div>
    @endif

    {{-- Surrounding Images --}}
    @foreach(array_slice($images, 1) as $index => $image)
        @php
            $angle = ($index * 72) - 90; // Distribute around circle
            $radius = 180;
            $x = cos(deg2rad($angle)) * $radius;
            $y = sin(deg2rad($angle)) * $radius;
        @endphp
        <div 
            class="absolute w-24 h-24 rounded-full overflow-hidden border-3 border-white dark:border-zinc-700 shadow-lg group transition-transform duration-500 hover:scale-125 hover:z-20"
            style="transform: translate({{ $x }}px, {{ $y }}px);"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover"
            />
        </div>
    @endforeach
</div>
