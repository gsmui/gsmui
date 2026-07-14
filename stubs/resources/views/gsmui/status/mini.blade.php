@props([
    'status' => 'online',
    'label' => '',
])

@php
$statuses = [
    'online' => 'bg-green-500',
    'offline' => 'bg-zinc-400',
    'away' => 'bg-yellow-500',
    'busy' => 'bg-red-500',
];
$dotColor = $statuses[$status] ?? $statuses['online'];
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-1 text-xs text-zinc-500 dark:text-zinc-400']) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    @if($label)
        {{ $label }}
    @endif
</span>
