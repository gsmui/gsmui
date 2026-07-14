@props([
    'value' => 0,
    'max' => 100,
    'size' => 'md',
    'color' => 'blue',
    'label' => null,
    'subtitle' => null,
    'prefix' => '',
    'suffix' => '%',
    'icon' => null,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 10;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'red' => '#ef4444', 'purple' => '#a855f7', 'orange' => '#f97316', 'teal' => '#14b8a6'];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-100 dark:text-zinc-800" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" class="transition-all duration-500" />
        </svg>
        <div class="absolute inset-0 flex flex-col items-center justify-center">
            @if($icon)
                <div class="mb-1" style="color: {{ $trackColor }};">
                    @if($icon === 'trend-up')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    @elseif($icon === 'trend-down')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                    @endif
                </div>
            @endif
            <span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 4 }}px;">{{ $prefix }}{{ round($value) }}{{ $suffix }}</span>
        </div>
    </div>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    @if($subtitle)<span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</span>@endif
</div>
