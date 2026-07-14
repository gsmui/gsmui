@props([
    'label' => 'Messages',
    'badge' => 5,
    'color' => 'blue',
    'size' => 'md',
])

@php
$badgeColors = [
    'blue' => 'bg-blue-500 text-white',
    'green' => 'bg-green-500 text-white',
    'red' => 'bg-red-500 text-white',
    'yellow' => 'bg-yellow-500 text-white',
];
$badgeClass = $badgeColors[$color] ?? $badgeColors['blue'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
    @if($badge > 0)
        <span class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full text-[10px] font-bold {{ $badgeClass }}">
            {{ $badge > 99 ? '99+' : $badge }}
        </span>
    @endif
</div>
