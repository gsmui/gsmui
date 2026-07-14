@props([
    'color' => 'zinc',
    'spacing' => '2',
    'thickness' => '2',
])

@php
$colors = [
    'blue' => 'border-blue-500',
    'green' => 'border-green-500',
    'purple' => 'border-purple-500',
    'red' => 'border-red-500',
    'zinc' => 'border-zinc-300 dark:border-zinc-600',
];

$colorClass = $colors[$color] ?? 'border-zinc-300';
@endphp

<div {{ $attributes->class([
    'rounded-xl border-dotted',
    $colorClass,
    "border-{$thickness}",
]) }}>
    {{ $slot }}
</div>
