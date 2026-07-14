@props([
    'label' => 'Active',
    'variant' => 'success',
    'size' => 'md',
])

@php
$variants = [
    'success' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    'error' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    'neutral' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400',
    'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
    'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400',
    'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400',
];
$variantClass = $variants[$variant] ?? $variants['success'];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-sm',
    'lg' => 'px-3 py-1.5 text-base',
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
