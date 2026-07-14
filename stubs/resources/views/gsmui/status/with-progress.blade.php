@props([
    'label' => 'Progress',
    'progress' => 50,
    'color' => 'blue',
    'size' => 'md',
    'showPercent' => true,
])

@php
$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'red' => 'bg-red-500',
    'yellow' => 'bg-yellow-500',
    'purple' => 'bg-purple-500',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$barHeights = ['sm' => 'h-1', 'md' => 'h-1.5', 'lg' => 'h-2'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-3']) }}>
    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
    <div class="flex items-center gap-2">
        <div class="w-24 {{ $barHeights[$size] ?? $barHeights['md'] }} bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
            <div class="h-full {{ $colorClass }} rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
        </div>
        @if($showPercent)
            <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $progress }}%</span>
        @endif
    </div>
</div>
