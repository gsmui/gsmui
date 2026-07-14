@props([
    'depth' => 'md',
    'shadow' => true,
    'border' => true,
])

@php
$depths = [
    'sm' => 'p-2',
    'md' => 'p-4',
    'lg' => 'p-6',
];

$depthClass = $depths[$depth] ?? 'p-4';
@endphp

<div {{ $attributes->class([
    'relative rounded-lg bg-zinc-100 dark:bg-zinc-800 dark:bg-zinc-800',
    $shadow ? 'shadow-[inset_4px_4px_8px_rgba(0,0,0,0.1),inset_-4px_-4px_8px_rgba(255,255,255,0.5)]' : '',
    $border ? 'border border-zinc-200 dark:border-zinc-700 dark:border-zinc-700' : '',
    $depthClass,
]) }}>
    <div class="bg-white dark:bg-zinc-800 dark:bg-zinc-900 rounded shadow-lg h-full">
        {{ $slot }}
    </div>
</div>
