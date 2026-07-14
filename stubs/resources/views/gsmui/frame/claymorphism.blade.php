@props([
    'color' => 'blue',
    'shadow' => true,
])

@php
$colors = [
    'blue' => 'bg-blue-200',
    'green' => 'bg-green-200',
    'purple' => 'bg-purple-200',
    'pink' => 'bg-pink-200',
    'amber' => 'bg-amber-200',
];

$shadowColors = [
    'blue' => 'shadow-[8px_8px_16px_rgba(59,130,246,0.2),-4px_-4px_12px_rgba(255,255,255,0.8)]',
    'green' => 'shadow-[8px_8px_16px_rgba(34,197,94,0.2),-4px_-4px_12px_rgba(255,255,255,0.8)]',
    'purple' => 'shadow-[8px_8px_16px_rgba(168,85,247,0.2),-4px_-4px_12px_rgba(255,255,255,0.8)]',
    'pink' => 'shadow-[8px_8px_16px_rgba(236,72,153,0.2),-4px_-4px_12px_rgba(255,255,255,0.8)]',
    'amber' => 'shadow-[8px_8px_16px_rgba(245,158,11,0.2),-4px_-4px_12px_rgba(255,255,255,0.8)]',
];

$colorClass = $colors[$color] ?? 'bg-blue-200';
$shadowClass = $shadowColors[$color] ?? 'shadow-[8px_8px_16px_rgba(59,130,246,0.2)]';
@endphp

<div {{ $attributes->class([
    'rounded-3xl',
    $colorClass,
    $shadow ? $shadowClass : '',
    'border-2 border-white/50',
]) }}>
    {{ $slot }}
</div>
