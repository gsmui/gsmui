@blaze(fold: true)

@props([
    'label' => null,
    'value' => null,
    'change' => null,
    'changeType' => 'neutral',
    'icon' => null,
    'size' => null,
])

@php
$changeIcon = match ($changeType) {
    'positive' => 'arrow-up-right',
    'negative' => 'arrow-down-right',
    default => 'minus',
};

$changeColor = match ($changeType) {
    'positive' => 'text-green-600 dark:text-green-400',
    'negative' => 'text-red-600 dark:text-red-400',
    default => 'text-zinc-500 dark:text-zinc-400',
};

$sizeClasses = match ($size) {
    'sm' => 'p-3',
    'lg' => 'p-6',
    default => 'p-4',
};
@endphp

<div {{ $attributes->class('flex flex-col gap-1 ' . $sizeClasses) }} data-gsmui-stat>
    <div class="flex items-center gap-2 text-zinc-500 dark:text-zinc-400 text-sm">
        @if ($icon)
            <gsmui:icon :name="$icon" variant="mini" />
        @endif
        <span>{{ $label }}</span>
    </div>
    <div class="text-2xl font-semibold tabular-nums text-zinc-900 dark:text-zinc-100">
        {{ $value }}
    </div>
    @if ($change)
        <div class="flex items-center gap-1 text-sm {{ $changeColor }}">
            <gsmui:icon :name="$changeIcon" variant="mini" />
            <span class="tabular-nums">{{ $change }}</span>
        </div>
    @endif
</div>
