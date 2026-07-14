@props([
    'color' => 'zinc',
    'width' => '2',
    'hover' => false,
])

@php
$colors = [
    'blue' => 'border-blue-500',
    'green' => 'border-green-500',
    'purple' => 'border-purple-500',
    'red' => 'border-red-500',
    'amber' => 'border-amber-500',
    'zinc' => 'border-zinc-300 dark:border-zinc-600',
];

$colorClass = $colors[$color] ?? 'border-zinc-300';
@endphp

<div {{ $attributes->class([
    'rounded-xl border-solid',
    $colorClass,
    "border-{$width}",
    $hover ? 'hover:border-blue-500 transition-colors' : '',
]) }}>
    {{ $slot }}
</div>
