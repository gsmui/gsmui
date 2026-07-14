@props([
    'value' => 0,
    'max' => 100,
    'size' => 'md',
    'color' => 'cyan',
    'label' => null,
    'showValue' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 8;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    $colors = ['cyan' => '#06b6d4', 'pink' => '#ec4899', 'green' => '#22c55e', 'purple' => '#a855f7', 'orange' => '#f97316', 'blue' => '#3b82f6'];
    $trackColor = $colors[$color] ?? $colors['cyan'];
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none bg-zinc-900 dark:bg-zinc-950 rounded-2xl p-4"]) }}
    x-data="{ glow: true }" x-init="setInterval(() => glow = !glow, 2000)"
>
    @if($label)<span class="text-sm font-medium text-zinc-400">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <div class="absolute inset-0 rounded-full opacity-50" :class="{ 'opacity-80': glow }" style="box-shadow: 0 0 30px 10px {{ $trackColor }}40, 0 0 60px 20px {{ $trackColor }}20;"></div>
        <svg class="w-full h-full -rotate-90 relative z-10" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}20" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" style="filter: drop-shadow(0 0 8px {{ $trackColor }}); transition: all 0.5s;" />
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center z-20"><span class="font-bold" style="color: {{ $trackColor }}; font-size: {{ $sizePx / 4 }}px; text-shadow: 0 0 10px {{ $trackColor }};">{{ round($percentage) }}%</span></div>@endif
    </div>
</div>
