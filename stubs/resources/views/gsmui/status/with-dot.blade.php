@props([
    'label' => 'With Dot',
    'dotColor' => 'green',
    'size' => 'md',
])

@php
$dotColors = [
    'green' => 'bg-green-500',
    'red' => 'bg-red-500',
    'yellow' => 'bg-yellow-500',
    'blue' => 'bg-blue-500',
    'purple' => 'bg-purple-500',
    'pink' => 'bg-pink-500',
];
$dotClass = $dotColors[$dotColor] ?? $dotColors['green'];
$sizes = ['sm' => 'text-xs gap-1.5', 'md' => 'text-sm gap-2', 'lg' => 'text-base gap-2.5'];
@endphp

<div {{ $attributes->class(['inline-flex items-center font-medium text-zinc-700 dark:text-zinc-300', $sizes[$size] ?? $sizes['md']]) }}>
    <span class="w-2 h-2 rounded-full {{ $dotClass }}"></span>
    {{ $label }}
</div>
