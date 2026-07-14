@props([
    'level' => 100,
    'status' => 'info',
    'size' => 'md',
    'showPercent' => true,
])

@php
$fillColor = match(true) {
    $level > 60 => 'bg-green-500',
    $level > 20 => 'bg-yellow-500',
    default => 'bg-red-500',
};

$sizes = [
    'sm' => 'h-3 w-6',
    'md' => 'h-4 w-8',
    'lg' => 'h-5 w-10',
];

$sizeClass = $sizes[$size] ?? 'h-4 w-8';
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-1.5']) }}>
    <div class="{{ $sizeClass }} relative rounded-sm border border-zinc-300 dark:border-zinc-600">
        <div class="absolute inset-0.5 rounded-[1px] {{ $fillColor }}" style="width: {{ max(5, $level) }}%"></div>
    </div>
    @if($showPercent)
        <span class="text-xs font-medium tabular-nums text-zinc-600 dark:text-zinc-400">{{ $level }}%</span>
    @endif
</div>
