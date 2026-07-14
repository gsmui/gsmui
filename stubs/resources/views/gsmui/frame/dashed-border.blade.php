@props([
    'color' => 'zinc',
    'hover' => false,
    'hoverColor' => 'blue',
])

@php
$colors = [
    'blue' => 'border-blue-500',
    'green' => 'border-green-500',
    'purple' => 'border-purple-500',
    'red' => 'border-red-500',
    'zinc' => 'border-zinc-300 dark:border-zinc-600',
];

$hoverColors = [
    'blue' => 'hover:border-blue-500',
    'green' => 'hover:border-green-500',
    'purple' => 'hover:border-purple-500',
    'red' => 'hover:border-red-500',
];

$colorClass = $colors[$color] ?? 'border-zinc-300';
$hoverColorClass = $hoverColors[$hoverColor] ?? 'hover:border-blue-500';
@endphp

<div {{ $attributes->class([
    'rounded-xl border-2 border-dashed',
    $colorClass,
    $hover ? $hoverColorClass : '',
    $hover ? 'transition-colors duration-200' : '',
]) }}>
    {{ $slot }}
</div>
