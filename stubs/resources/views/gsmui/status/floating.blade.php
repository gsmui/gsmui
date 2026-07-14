@props([
    'label' => 'Floating',
    'status' => 'online',
    'position' => 'top-right',
    'size' => 'md',
])

@php
$statuses = [
    'online' => 'bg-green-500',
    'offline' => 'bg-zinc-400',
    'away' => 'bg-yellow-500',
    'busy' => 'bg-red-500',
];
$dotColor = $statuses[$status] ?? $statuses['online'];

$positions = [
    'top-right' => '-top-1 -right-1',
    'top-left' => '-top-1 -left-1',
    'bottom-right' => '-bottom-1 -right-1',
    'bottom-left' => '-bottom-1 -left-1',
];
$posClass = $positions[$position] ?? $positions['top-right'];
@endphp

<div {{ $attributes->class(['relative inline-block']) }}>
    {{ $slot }}
    <span class="absolute {{ $posClass }} flex h-3 w-3">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $dotColor }} opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 {{ $dotColor }}"></span>
    </span>
</div>
