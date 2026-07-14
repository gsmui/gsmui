@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'isometricAngle' => 60,
])

<div {{ $attributes->class(["relative py-20"]) }}>
    <div 
        class="grid grid-cols-{{ $columns }} gap-{{ $gap }}"
        style="transform: rotateX({{ $isometricAngle }}deg) rotateZ(-45deg); transform-style: preserve-3d;"
    >
        @foreach($images as $index => $image)
            <div 
                class="group relative aspect-square overflow-hidden rounded-lg shadow-2xl"
                style="transform: translateZ({{ $index * 10 }}px);"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110 group-hover:brightness-110"
                />
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity -z-10 blur"></div>
            </div>
        @endforeach
    </div>
</div>
