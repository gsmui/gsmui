@props([
    'border' => 'subtle',
    'padding' => 'md',
])

@php
$borders = [
    'none' => '',
    'subtle' => 'border border-zinc-100 dark:border-zinc-800',
    'light' => 'border border-zinc-200 dark:border-zinc-700 dark:border-zinc-700',
    'accent' => 'border border-blue-200 dark:border-blue-800',
];

$paddings = [
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
    'none' => '',
];

$borderClass = $borders[$border] ?? 'border border-zinc-100';
$paddingClass = $paddings[$padding] ?? 'p-6';
@endphp

<div {{ $attributes->class([
    $borderClass,
    $paddingClass,
    'bg-white dark:bg-zinc-800 dark:bg-zinc-900',
]) }}>
    {{ $slot }}
</div>
