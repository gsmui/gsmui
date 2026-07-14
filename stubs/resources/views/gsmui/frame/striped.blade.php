@props([
    'color' => 'blue',
    'width' => '4',
    'style' => 'solid',
])

@php
$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
    'red' => 'bg-red-500',
    'amber' => 'bg-amber-500',
];

$widths = [
    '2' => 'border-2',
    '4' => 'border-4',
    '8' => 'border-8',
];

$colorClass = $colors[$color] ?? 'bg-blue-500';
$widthClass = $widths[$width] ?? 'border-4';
@endphp

<div class="relative">
    <div class="absolute inset-0 rounded-xl {{ $colorClass }} opacity-20"></div>
    <div {{ $attributes->class([
        'relative rounded-xl bg-white dark:bg-zinc-800 dark:bg-zinc-900 m-1',
    ]) }}>
        {{ $slot }}
    </div>
</div>
