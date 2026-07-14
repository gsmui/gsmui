@props([
    'priority' => 'medium',
    'size' => 'md',
])

@php
$priorities = [
    'urgent' => ['label' => 'Urgent', 'classes' => 'bg-red-100 text-red-800 border-red-300 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800'],
    'high' => ['label' => 'High', 'classes' => 'bg-orange-100 text-orange-800 border-orange-300 dark:bg-orange-900/30 dark:text-orange-400 dark:border-orange-800'],
    'medium' => ['label' => 'Medium', 'classes' => 'bg-yellow-100 text-yellow-800 border-yellow-300 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800'],
    'low' => ['label' => 'Low', 'classes' => 'bg-blue-100 text-blue-800 border-blue-300 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800'],
    'none' => ['label' => 'None', 'classes' => 'bg-zinc-100 text-zinc-600 border-zinc-300 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-700'],
];

$sizes = [
    'sm' => 'px-1.5 py-0.5 text-[10px]',
    'md' => 'px-2 py-0.5 text-xs',
    'lg' => 'px-2.5 py-1 text-sm',
];

$priorityData = $priorities[$priority] ?? $priorities['medium'];
$sizeClass = $sizes[$size] ?? 'px-2 py-0.5 text-xs';
@endphp

<span {{ $attributes->class(['inline-flex items-center rounded-full border font-medium', $sizeClass, $priorityData['classes']]) }}>
    {{ $priorityData['label'] }}
</span>
