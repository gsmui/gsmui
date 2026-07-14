@props([
    'radius' => 'lg',
    'border' => true,
    'shadow' => false,
    'hover' => false,
])

@php
$radii = [
    'none' => '',
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    '2xl' => 'rounded-2xl',
    '3xl' => 'rounded-3xl',
    'full' => 'rounded-full',
];

$radiusClass = $radii[$radius] ?? 'rounded-lg';
@endphp

<div {{ $attributes->class([
    'overflow-hidden',
    $radiusClass,
    $border ? 'border border-zinc-200 dark:border-zinc-700' : '',
    $shadow ? 'shadow-lg' : '',
    $hover ? 'hover:shadow-xl transition-shadow duration-300' : '',
]) }}>
    {{ $slot }}
</div>
