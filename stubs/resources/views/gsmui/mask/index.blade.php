@blaze(fold: true)

@props([
    'shape' => 'squircle',
    'src' => null,
    'alt' => null,
    'size' => null,
])

@php
$sizeClass = match ($size) {
    'xs' => 'size-16',
    'sm' => 'size-24',
    'lg' => 'size-40',
    'xl' => 'size-56',
    default => 'size-32',
};

// SVG mask paths — using inline style for browser compatibility
$maskSVGs = [
    'squircle' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpath d='M100 0C120 0 140 5 160 20 180 35 190 55 195 80 200 100 200 120 195 145 190 170 175 185 160 195 140 200 120 200 100 200 80 200 55 195 35 185 15 170 5 145 0 120 0 100 0 75 5 50 10 30 25 15 45 5 65 0 85 0 100 0Z' fill='black'/%3E%3C/svg%3E",

    'heart' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpath d='M100 180C100 180 10 120 10 65 10 35 30 10 60 10 80 10 95 25 100 40 105 25 120 10 140 10 170 10 190 35 190 65 190 120 100 180 100 180Z' fill='black'/%3E%3C/svg%3E",

    'hexagon' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpath d='M100 0L190 50 190 150 100 200 10 150 10 50Z' fill='black'/%3E%3C/svg%3E",

    'hexagon-2' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpath d='M50 0L150 0 200 100 150 200 50 200 0 100Z' fill='black'/%3E%3C/svg%3E",

    'decagon' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpolygon points='100,5 140,20 175,55 190,95 185,135 165,170 130,190 90,195 50,180 20,145 10,105 15,65 35,30 65,10' fill='black'/%3E%3C/svg%3E",

    'pentagon' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpolygon points='100,5 190,75 155,185 45,185 10,75' fill='black'/%3E%3C/svg%3E",

    'diamond' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpolygon points='100,0 200,100 100,200 0,100' fill='black'/%3E%3C/svg%3E",

    'square' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Crect width='200' height='200' fill='black'/%3E%3C/svg%3E",

    'circle' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Ccircle cx='100' cy='100' r='95' fill='black'/%3E%3C/svg%3E",

    'star' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpolygon points='100,5 125,70 190,75 140,120 155,185 100,145 45,185 60,120 10,75 75,70' fill='black'/%3E%3C/svg%3E",

    'star-2' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpolygon points='100,0 122,68 195,75 140,120 155,195 100,150 45,195 60,120 5,75 78,68' fill='black'/%3E%3C/svg%3E",

    'triangle' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpolygon points='100,10 190,190 10,190' fill='black'/%3E%3C/svg%3E",

    'triangle-2' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpolygon points='10,10 190,10 100,190' fill='black'/%3E%3C/svg%3E",

    'triangle-3' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpolygon points='190,10 10,100 190,190' fill='black'/%3E%3C/svg%3E",

    'triangle-4' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpolygon points='10,10 190,100 10,190' fill='black'/%3E%3C/svg%3E",

    'blob' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpath d='M140 20C170 30 195 65 195 100 195 135 175 165 150 180 120 195 85 200 55 185 25 170 5 140 5 105 5 70 20 35 50 20 75 5 110 10 140 20Z' fill='black'/%3E%3C/svg%3E",

    'drop' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpath d='M100 10C100 10 185 110 185 150 185 200 15 200 15 150 15 110 100 10 100 10Z' fill='black'/%3E%3C/svg%3E",

    'ribbon' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cpath d='M100 10L190 40 190 160 100 190 10 160 10 40Z' fill='black'/%3E%3C/svg%3E",
];

$maskUrl = $maskSVGs[$shape] ?? $maskSVGs['squircle'];

$classes = Gsmui::classes()
    ->add('inline-flex items-center justify-center overflow-hidden bg-zinc-200 dark:bg-zinc-700')
    ->add($sizeClass)
    ;
@endphp

@if ($src)
    <img
        src="{{ $src }}"
        alt="{{ $alt ?? '' }}"
        {{ $attributes->class($classes) }}
        style="-webkit-mask: url('{{ $maskUrl }}') no-repeat center / contain; mask: url('{{ $maskUrl }}') no-repeat center / contain;"
        data-gsmui-mask
    />
@else
    <div
        {{ $attributes->class($classes) }}
        style="-webkit-mask: url('{{ $maskUrl }}') no-repeat center / contain; mask: url('{{ $maskUrl }}') no-repeat center / contain;"
        data-gsmui-mask
    >
        {{ $slot }}
    </div>
@endif
