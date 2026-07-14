@props([
    'curve' => 'bottom',
    'color' => 'blue',
    'height' => '24',
])

@php
$curves = [
    'bottom' => 'rounded-b-[50px]',
    'top' => 'rounded-t-[50px]',
    'left' => 'rounded-l-[50px]',
    'right' => 'rounded-r-[50px]',
];

$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
    'pink' => 'bg-pink-500',
];

$curveClass = $curves[$curve] ?? 'rounded-b-[50px]';
$colorClass = $colors[$color] ?? 'bg-blue-500';
@endphp

<div {{ $attributes->class([
    'relative',
    $colorClass,
    $curveClass,
]) }}>
    {{ $slot }}
</div>
