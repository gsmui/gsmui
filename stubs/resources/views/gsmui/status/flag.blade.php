@props([
    'flagged' => false,
    'count' => 0,
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'h-3 w-3',
    'md' => 'h-4 w-4',
    'lg' => 'h-5 w-5',
];

$sizeClass = $sizes[$size] ?? 'h-4 w-4';
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-1']) }}>
    <svg class="{{ $sizeClass }} {{ $flagged ? 'text-red-500' : 'text-zinc-400' }}" fill="currentColor" viewBox="0 0 24 24">
        <path d="M14.4 6L14 4H5v17h2v-7h5.6l.4 2h7V6h-5.6z"/>
    </svg>
    @if($count > 0)
        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400 tabular-nums">{{ $count }}</span>
    @endif
</div>
