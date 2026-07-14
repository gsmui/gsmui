@props([
    'direction' => 'right',
    'color' => 'blue',
    'size' => '20',
])

@php
$directions = [
    'right' => 'clip-path-[polygon(0_0,100%_0,100%_calc(100%-' . $size . 'px),calc(100%-' . $size . 'px)_100%,0_100%)]',
    'left' => 'clip-path-[polygon(0_0,100%_0,100%_100%,' . $size . 'px_100%,0_calc(100%-' . $size . 'px))]',
    'top' => 'clip-path-[polygon(0_' . $size . 'px,100%_0,100%_100%,0_100%)]',
    'bottom' => 'clip-path-[polygon(0_0,100%_0,100%_calc(100%-' . $size . 'px),0_100%)]',
];

$directionClass = $directions[$direction] ?? 'clip-path-[polygon(0_0,100%_0,100%_calc(100%-20px),calc(100%-20px)_100%,0_100%)]';
@endphp

<div {{ $attributes->class([
    'overflow-hidden',
    $directionClass,
]) }}>
    {{ $slot }}
</div>
