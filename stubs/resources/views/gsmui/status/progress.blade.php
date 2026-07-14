@props([
    'label' => 'Progress',
    'value' => 0,
    'max' => 100,
    'color' => 'blue',
    'size' => 'md',
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'red' => 'bg-red-500',
    'yellow' => 'bg-yellow-500',
    'purple' => 'bg-purple-500',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$heights = ['sm' => 'h-1', 'md' => 'h-1.5', 'lg' => 'h-2'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-3']) }}>
    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
    <div class="w-32 {{ $heights[$size] ?? $heights['md'] }} bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
        <div class="h-full {{ $colorClass }} rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
    </div>
    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 min-w-[3ch] text-right">{{ round($percentage) }}%</span>
</div>
