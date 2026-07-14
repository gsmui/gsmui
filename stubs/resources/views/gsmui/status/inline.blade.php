@props([
    'label' => 'active',
    'variant' => 'success',
    'size' => 'sm',
])

@php
$variants = [
    'success' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
    'error' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    'warning' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
    'info' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
    'neutral' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400',
];
$variantClass = $variants[$variant] ?? $variants['success'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded px-1.5 py-0.5 text-xs', $variantClass]) }}>
    {{ $label }}
</span>
