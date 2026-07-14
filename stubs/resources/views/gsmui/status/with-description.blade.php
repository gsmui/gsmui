@props([
    'label' => 'Status',
    'description' => 'Additional information',
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

<div {{ $attributes->class(['inline-flex items-start gap-2']) }}>
    <span class="mt-1 flex-shrink-0 w-2 h-2 rounded-full {{ $statusSet['dot'] }}"></span>
    <div>
        <span class="font-medium {{ $statusSet['text'] }} text-sm">{{ $label }}</span>
        @if($description)
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $description }}</p>
        @endif
    </div>
</div>
