@props([
    'label' => 'User Status',
    'avatar' => null,
    'status' => 'online',
    'size' => 'md',
])

@php
$statusColors = [
    'online' => 'bg-green-500',
    'offline' => 'bg-zinc-400',
    'away' => 'bg-yellow-500',
    'busy' => 'bg-red-500',
];
$dotColor = $statusColors[$status] ?? $statusColors['online'];
$sizes = ['sm' => 'w-6 h-6 text-xs', 'md' => 'w-8 h-8 text-sm', 'lg' => 'w-10 h-10 text-base'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    <div class="relative flex-shrink-0">
        @if($avatar)
            <img src="{{ $avatar }}" alt="" class="{{ $sizes[$size] ?? $sizes['md'] }} rounded-full object-cover">
        @else
            <div class="{{ $sizes[$size] ?? $sizes['md'] }} rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-500 dark:text-zinc-400">
                👤
            </div>
        @endif
        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full {{ $dotColor }} border-2 border-white dark:border-zinc-800"></span>
    </div>
    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
</div>
