@props([
    'label' => 'Notification',
    'status' => 'info',
    'title' => 'Notification Title',
    'description' => 'Notification description text',
    'dismissible' => true,
    'size' => 'md',
])

@php
$statuses = [
    'success' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-green-200 dark:border-green-800', 'icon' => '✓', 'iconBg' => 'bg-green-100 dark:bg-green-900/40', 'iconColor' => 'text-green-600 dark:text-green-400'],
    'error' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'border' => 'border-red-200 dark:border-red-800', 'icon' => '✕', 'iconBg' => 'bg-red-100 dark:bg-red-900/40', 'iconColor' => 'text-red-600 dark:text-red-400'],
    'warning' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'border' => 'border-yellow-200 dark:border-yellow-800', 'icon' => '⚠', 'iconBg' => 'bg-yellow-100 dark:bg-yellow-900/40', 'iconColor' => 'text-yellow-600 dark:text-yellow-400'],
    'info' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-200 dark:border-blue-800', 'icon' => 'ℹ', 'iconBg' => 'bg-blue-100 dark:bg-blue-900/40', 'iconColor' => 'text-blue-600 dark:text-blue-400'],
];
$statusSet = $statuses[$status] ?? $statuses['info'];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition
     {{ $attributes->class(['flex items-start gap-3 p-4 rounded-lg border', $statusSet['bg'], $statusSet['border']]) }}>
    <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $statusSet['iconBg'] }} flex items-center justify-center">
        <span class="{{ $statusSet['iconColor'] }}">{{ $statusSet['icon'] }}</span>
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $title }}</p>
        @if($description)
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $description }}</p>
        @endif
    </div>
    @if($dismissible)
        <button @click="show = false" class="flex-shrink-0 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</div>
