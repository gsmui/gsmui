@props([
    'level' => 'md',
    'color' => null,
    'hover' => false,
])

@php
$shadows = [
    'sm' => 'shadow-sm',
    'md' => 'shadow-md',
    'lg' => 'shadow-lg',
    'xl' => 'shadow-xl',
    '2xl' => 'shadow-2xl',
    'inner' => 'shadow-inner',
    'none' => 'shadow-none',
];

$shadowClass = $shadows[$level] ?? 'shadow-md';

$colorShadows = [
    'blue' => 'shadow-blue-500/30',
    'green' => 'shadow-green-500/30',
    'purple' => 'shadow-purple-500/30',
    'red' => 'shadow-red-500/30',
];

$colorClass = $color ? ($colorShadows[$color] ?? '') : '';
@endphp

<div {{ $attributes->class([
    'rounded-xl',
    $shadowClass,
    $colorClass,
    $hover ? 'hover:shadow-2xl transition-shadow duration-300' : '',
]) }}>
    {{ $slot }}
</div>
