@props([
    'shape' => 'circle',
    'color' => 'white',
])

@php
$shapes = [
    'circle' => 'clip-path-circle',
    'ellipse' => 'clip-path-ellipse',
    'polygon' => 'clip-path-polygon',
    'hexagon' => 'clip-path-hexagon',
];

$shapeClass = $shapes[$shape] ?? 'clip-path-circle';
@endphp

<div {{ $attributes->class([
    'overflow-hidden',
    $shape === 'circle' ? 'rounded-full' : 'rounded-xl',
]) }}>
    {{ $slot }}
</div>
