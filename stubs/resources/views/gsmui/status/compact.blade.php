@props([
    'label' => 'Compact',
    'status' => 'success',
    'size' => 'sm',
])

@php
$statuses = [
    'success' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    'error' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    'neutral' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400',
];
$colorClass = $statuses[$status] ?? $statuses['success'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded px-1.5 py-0.5 text-[10px] uppercase tracking-wide', $colorClass]) }}>
    {{ $label }}
</span>
