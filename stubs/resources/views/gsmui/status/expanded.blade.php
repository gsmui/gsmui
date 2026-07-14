@props([
    'label' => 'Expanded Status',
    'description' => 'This is a detailed status with additional information and actions',
    'status' => 'info',
    'actions' => [],
])

@php
$statuses = [
    'success' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-green-200 dark:border-green-800', 'icon' => '✓', 'iconColor' => 'text-green-500', 'text' => 'text-green-800 dark:text-green-300'],
    'error' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'border' => 'border-red-200 dark:border-red-800', 'icon' => '✕', 'iconColor' => 'text-red-500', 'text' => 'text-red-800 dark:text-red-300'],
    'warning' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'border' => 'border-yellow-200 dark:border-yellow-800', 'icon' => '⚠', 'iconColor' => 'text-yellow-500', 'text' => 'text-yellow-800 dark:text-yellow-300'],
    'info' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-200 dark:border-blue-800', 'icon' => 'ℹ', 'iconColor' => 'text-blue-500', 'text' => 'text-blue-800 dark:text-blue-300'],
];
$statusSet = $statuses[$status] ?? $statuses['info'];
@endphp

<div {{ $attributes->class(['rounded-xl border p-5', $statusSet['bg'], $statusSet['border']]) }}>
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-white dark:bg-zinc-800 flex items-center justify-center shadow-sm">
            <span class="text-xl {{ $statusSet['iconColor'] }}">{{ $statusSet['icon'] }}</span>
        </div>
        <div class="flex-1 min-w-0">
            <h4 class="font-semibold {{ $statusSet['text'] }}">{{ $label }}</h4>
            @if($description)
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $description }}</p>
            @endif
            @if(count($actions) > 0)
                <div class="flex items-center gap-2 mt-3">
                    @foreach($actions as $action)
                        <button class="px-3 py-1 text-xs font-medium rounded-md {{ $statusSet['text'] }} hover:bg-black/5 dark:hover:bg-white/10 transition-colors">
                            {{ $action['label'] ?? '' }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
