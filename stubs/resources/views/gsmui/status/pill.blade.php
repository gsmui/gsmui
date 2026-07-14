@props([
    'label' => 'Active',
    'variant' => 'success',
    'size' => 'md',
])

@php
$variants = [
    'success' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800',
    'error' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800',
    'warning' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800',
    'info' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800',
    'neutral' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700',
];
$variantClass = $variants[$variant] ?? $variants['success'];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-3 py-1 text-sm',
    'lg' => 'px-4 py-1.5 text-base',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<span {{ $attributes->class([
    'inline-flex items-center font-medium rounded-full',
    $variantClass,
    $sizeClass,
]) }}>
    {{ $label }}
</span>
