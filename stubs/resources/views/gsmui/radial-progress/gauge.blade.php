@props([
    'value' => 0,
    'max' => 100,
    'min' => 0,
    'size' => 'md',
    'label' => null,
    'showValue' => true,
    'minLabel' => 'Min',
    'maxLabel' => 'Max',
])

@php
    $sizes = ['sm' => 120, 'md' => 160, 'lg' => 200, 'xl' => 240];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 16;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = pi() * $radius;
    $percentage = $max > $min ? min(100, max(0, (($value - $min) / ($max - $min)) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    
    $color = $percentage < 33 ? '#22c55e' : ($percentage < 66 ? '#f59e0b' : '#ef4444');
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx / 2 + 20 }}px;">
        <svg class="w-full h-full" viewBox="0 0 {{ $sizePx }} {{ $sizePx / 2 + 20 }}" style="clip-path: inset(0 0 0 0);">
            <path d="M {{ $strokeWidth / 2 }} {{ $sizePx / 2 + 10 }} A {{ $radius }} {{ $radius }} 0 0 1 {{ $sizePx - $strokeWidth / 2 }} {{ $sizePx / 2 + 10 }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" />
            <path d="M {{ $strokeWidth / 2 }} {{ $sizePx / 2 + 10 }} A {{ $radius }} {{ $radius }} 0 0 1 {{ $sizePx - $strokeWidth / 2 }} {{ $sizePx / 2 + 10 }}" fill="none" stroke="{{ $color }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" class="transition-all duration-500" />
        </svg>
        @if($showValue)<div class="absolute inset-x-0 bottom-0 flex justify-center"><span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 5 }}px;">{{ round($value) }}</span></div>@endif
        <div class="absolute bottom-0 left-2 text-xs text-zinc-500">{{ $minLabel }}</div>
        <div class="absolute bottom-0 right-2 text-xs text-zinc-500">{{ $maxLabel }}</div>
    </div>
</div>
