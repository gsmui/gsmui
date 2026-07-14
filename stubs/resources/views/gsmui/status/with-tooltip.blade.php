@props([
    'label' => 'Status',
    'tooltip' => 'This is a tooltip',
    'status' => 'success',
    'size' => 'md',
])

@php
$statuses = [
    'success' => ['dot' => 'bg-green-500', 'text' => 'text-green-700 dark:text-green-400'],
    'error' => ['dot' => 'bg-red-500', 'text' => 'text-red-700 dark:text-red-400'],
    'warning' => ['dot' => 'bg-yellow-500', 'text' => 'text-yellow-700 dark:text-yellow-400'],
    'info' => ['dot' => 'bg-blue-500', 'text' => 'text-blue-700 dark:text-blue-400'],
];
$statusSet = $statuses[$status] ?? $statuses['success'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-1.5 group relative']) }}>
    <span class="w-2 h-2 rounded-full {{ $statusSet['dot'] }}"></span>
    <span class="font-medium {{ $statusSet['text'] }} text-sm">{{ $label }}</span>
    
    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-zinc-900 dark:bg-zinc-700 text-white text-xs rounded-lg
                opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-lg">
        {{ $tooltip }}
    </div>
</div>
