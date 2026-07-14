@props([
    'tag' => '',
    'count' => null,
    'size' => 'md',
    'color' => 'blue',
])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    'green' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
    'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400',
    'zinc' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400',
];

$sizes = [
    'sm' => 'px-1.5 py-0.5 text-[10px]',
    'md' => 'px-2 py-0.5 text-xs',
    'lg' => 'px-2.5 py-1 text-sm',
];

$colorClass = $colors[$color] ?? $colors['blue'];
$sizeClass = $sizes[$size] ?? 'px-2 py-0.5 text-xs';
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-0.5 rounded-full font-medium', $sizeClass, $colorClass]) }}>
    <span class="opacity-70">#</span>{{ $tag }}
    @if($count !== null)
        <span class="ml-0.5 opacity-70">{{ $count }}</span>
    @endif
</span>
