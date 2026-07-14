@props([
    'version' => '1.0.0',
    'type' => 'stable',
    'size' => 'md',
])

@php
$types = [
    'stable' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    'beta' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
    'alpha' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
    'rc' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    'deprecated' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    'latest' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
];

$sizes = [
    'sm' => 'px-1.5 py-0.5 text-[10px]',
    'md' => 'px-2 py-0.5 text-xs',
    'lg' => 'px-2.5 py-1 text-sm',
];

$colorClass = $types[$type] ?? $types['stable'];
$sizeClass = $sizes[$size] ?? 'px-2 py-0.5 text-xs';
@endphp

<span {{ $attributes->class(['inline-flex items-center rounded-full font-mono font-semibold tabular-nums', $sizeClass, $colorClass]) }}>
    v{{ $version }}
</span>
