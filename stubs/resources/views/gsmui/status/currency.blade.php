@props([
    'amount' => '0.00',
    'currency' => 'USD',
    'status' => 'paid',
    'size' => 'md',
])

@php
$statuses = [
    'paid' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
    'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
    'failed' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    'refunded' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
];
$colorClass = $statuses[$status] ?? $statuses['paid'];
$sizes = ['sm' => 'text-xs', 'md' => 'text-sm', 'lg' => 'text-base'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    <span class="font-semibold {{ $sizes[$size] ?? $sizes['md'] }} text-zinc-900 dark:text-white">${{ number_format((float)$amount, 2) }}</span>
    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $colorClass }}">{{ ucfirst($status) }}</span>
</div>
