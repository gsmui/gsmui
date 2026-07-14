@props([
    'percentage' => 99.9,
    'size' => 'md',
])

@php
$color = match(true) {
    $percentage >= 99 => 'bg-green-500',
    $percentage >= 95 => 'bg-yellow-500',
    default => 'bg-red-500',
};

$textColor = match(true) {
    $percentage >= 99 => 'text-green-700 dark:text-green-400',
    $percentage >= 95 => 'text-yellow-700 dark:text-yellow-400',
    default => 'text-red-700 dark:text-red-400',
};

$sizes = [
    'sm' => 'h-2 w-2 text-xs gap-1',
    'md' => 'h-2.5 w-2.5 text-sm gap-1.5',
    'lg' => 'h-3 w-3 text-base gap-2',
];

$sizeClass = $sizes[$size] ?? 'h-2.5 w-2.5 text-sm gap-1.5';
@endphp

<div {{ $attributes->class(['inline-flex items-center', $sizeClass]) }}>
    <span class="rounded-full {{ $sizeClass }} {{ $color }}"></span>
    <span class="font-semibold tabular-nums {{ $textColor }}">{{ $percentage }}% uptime</span>
</div>
