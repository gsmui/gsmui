@props([
    'emoji' => '👍',
    'count' => 0,
    'active' => false,
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'h-6 px-1.5 text-xs gap-1',
    'md' => 'h-7 px-2 text-sm gap-1.5',
    'lg' => 'h-8 px-2.5 text-base gap-1.5',
];

$emojiSizes = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];

$sizeClass = $sizes[$size] ?? 'h-7 px-2 text-sm gap-1.5';
$emojiSize = $emojiSizes[$size] ?? 'text-sm';
@endphp

<button @class([
    'inline-flex items-center rounded-full border transition-colors',
    $sizeClass,
    $active
        ? 'border-blue-300 bg-blue-50 dark:border-blue-700 dark:bg-blue-900/30'
        : 'border-zinc-200 bg-white hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:bg-zinc-700',
]) {{ $attributes }}>
    <span class="{{ $emojiSize }}">{{ $emoji }}</span>
    @if($count > 0)
        <span class="font-medium tabular-nums text-zinc-600 dark:text-zinc-400">{{ $count }}</span>
    @endif
</button>
