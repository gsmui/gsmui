@props([
    'color' => 'zinc',
    'inset' => false,
])

@php
$colors = [
    'zinc' => ['bg' => 'bg-zinc-100 dark:bg-zinc-800 dark:bg-zinc-800', 'shadow' => 'shadow-[8px_8px_16px_rgba(0,0,0,0.1),-8px_-8px_16px_rgba(255,255,255,0.7)]'],
    'white' => ['bg' => 'bg-white dark:bg-zinc-800', 'shadow' => 'shadow-[8px_8px_16px_rgba(0,0,0,0.1),-8px_-8px_16px_rgba(255,255,255,0.7)]'],
    'slate' => ['bg' => 'bg-slate-100', 'shadow' => 'shadow-[8px_8px_16px_rgba(0,0,0,0.1),-8px_-8px_16px_rgba(255,255,255,0.5)]'],
];

$colorData = $colors[$color] ?? $colors['zinc'];

$insetShadow = 'shadow-[inset_8px_8px_16px_rgba(0,0,0,0.1),inset_-8px_-8px_16px_rgba(255,255,255,0.7)]';
@endphp

<div {{ $attributes->class([
    'rounded-2xl',
    $colorData['bg'],
    $inset ? $insetShadow : $colorData['shadow'],
]) }}>
    {{ $slot }}
</div>
