@props([
    'perspective' => 'md',
    'rotateX' => 0,
    'rotateY' => 0,
    'hover' => false,
])

@php
$perspectives = [
    'sm' => '500px',
    'md' => '1000px',
    'lg' => '1500px',
    'none' => 'none',
];

$perspectiveValue = $perspectives[$perspective] ?? '1000px';
@endphp

<div style="perspective: {{ $perspectiveValue }};">
    <div {{ $attributes->class([
        'rounded-xl transition-transform duration-300',
        $hover ? 'hover:scale-105' : '',
    ]) }} style="transform: rotateX({{ $rotateX }}deg) rotateY({{ $rotateY }}deg);">
        {{ $slot }}
    </div>
</div>
