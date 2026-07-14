@props([
    'color' => 'red',
    'style' => 'wavy',
])

@php
$colors = [
    'red' => 'bg-red-100 dark:bg-red-900/30 border-red-300',
    'blue' => 'bg-blue-100 dark:bg-blue-900/30 border-blue-300',
    'green' => 'bg-green-100 dark:bg-green-900/30 border-green-300',
];

$colorClass = $colors[$color] ?? 'bg-red-100 border-red-300';
@endphp

<div {{ $attributes->class([
    $colorClass,
    'border-2 p-4',
    $style === 'wavy' ? 'rounded-[2px]' : '',
    $style === 'serrated' ? 'border-dashed' : '',
]) }}>
    {{ $slot }}
</div>
