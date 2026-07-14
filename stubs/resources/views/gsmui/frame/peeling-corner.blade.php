@props([
    'position' => 'bottom-right',
    'size' => '40',
    'color' => 'zinc',
])

@php
$positions = [
    'bottom-right' => 'bottom-0 right-0',
    'bottom-left' => 'bottom-0 left-0',
    'top-right' => 'top-0 right-0',
    'top-left' => 'top-0 left-0',
];

$colors = [
    'zinc' => 'bg-zinc-300 dark:bg-zinc-600',
    'white' => 'bg-white dark:bg-zinc-800',
    'amber' => 'bg-amber-200',
];

$positionClass = $positions[$position] ?? 'bottom-0 right-0';
$colorClass = $colors[$color] ?? 'bg-zinc-300';
@endphp

<div class="relative overflow-hidden rounded-xl shadow-lg">
    {{ $slot }}
    
    <div class="absolute {{ $positionClass }} w-0 h-0"
         style="border-style: solid; border-width: 0 0 {{ $size }}px {{ $size }}px; border-color: transparent transparent {{ $colorClass }} transparent;">
    </div>
</div>
