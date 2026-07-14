@props([
    'size' => 'md',
    'ring' => false,
    'ringColor' => 'blue',
    'ringWidth' => 2,
])

@php
$sizes = [
    'xs' => 'w-8 h-8',
    'sm' => 'w-10 h-10',
    'md' => 'w-12 h-12',
    'lg' => 'w-16 h-16',
    'xl' => 'w-20 h-20',
    '2xl' => 'w-24 h-24',
];

$ringColors = [
    'blue' => 'ring-blue-500',
    'green' => 'ring-green-500',
    'purple' => 'ring-purple-500',
    'red' => 'ring-red-500',
    'white' => 'ring-white',
];

$sizeClass = $sizes[$size] ?? 'w-12 h-12';
$ringColorClass = $ringColors[$ringColor] ?? 'ring-blue-500';
@endphp

<div {{ $attributes->class([
    'rounded-full overflow-hidden',
    $sizeClass,
    $ring ? "ring-{$ringWidth} {$ringColorClass}" : '',
]) }}>
    {{ $slot }}
</div>
