@props([
    'shape' => 'rounded',
])

@php
$shapes = [
    'rounded' => '',
    'circle' => 'rounded-full',
    'diamond' => 'rotate-45',
    'hexagon' => 'clip-path-[polygon(50%_0%,100%_25%,100%_75%,50%_100%,0%_75%,0%_25%)]',
    'pentagon' => 'clip-path-[polygon(50%_0%,100%_38%,82%_100%,18%_100%,0%_38%)]',
    'octagon' => 'clip-path-[polygon(30%_0%,70%_0%,100%_30%,100%_70%,70%_100%,30%_100%,0%_70%,0%_30%)]',
    'star' => 'clip-path-[polygon(50%_0%,61%_35%,98%_35%,68%_57%,79%_91%,50%_70%,21%_91%,32%_57%,2%_35%,39%_35%)]',
    'arrow' => 'clip-path-[polygon(0%_0%,80%_0%,100%_50%,80%_100%,0%_100%,20%_50%)]',
];

$shapeClass = $shapes[$shape] ?? '';
@endphp

<div {{ $attributes->class(['overflow-hidden', $shapeClass]) }}>
    {{ $slot }}
</div>
