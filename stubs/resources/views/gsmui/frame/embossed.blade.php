@props([
    'depth' => 'md',
    'inset' => false,
])

@php
$depths = [
    'sm' => $inset ? 'shadow-inner' : 'shadow-sm',
    'md' => $inset ? 'shadow-inner shadow-lg' : 'shadow-md',
    'lg' => $inset ? 'shadow-inner shadow-xl' : 'shadow-lg',
];

$depthClass = $depths[$depth] ?? 'shadow-md';
@endphp

<div {{ $attributes->class([
    'rounded-xl bg-zinc-100 dark:bg-zinc-800',
    $depthClass,
    $inset ? 'border border-zinc-300 dark:border-zinc-600' : 'border border-zinc-200 dark:border-zinc-700',
]) }}>
    {{ $slot }}
</div>
