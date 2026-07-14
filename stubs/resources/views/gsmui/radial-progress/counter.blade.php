@props([
    'value' => 0,
    'max' => 100,
    'size' => 'md',
    'color' => 'blue',
    'label' => null,
    'showValue' => true,
    'duration' => 1500,
])

@php
    $sizes = ['xs' => 32, 'sm' => 48, 'md' => 64, 'lg' => 96, 'xl' => 128];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = $sizePx / 8;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'red' => '#ef4444', 'purple' => '#a855f7', 'orange' => '#f97316'];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}
    x-data="{ count: 0, target: {{ $percentage }}, mounted: false }"
    x-init="setTimeout(() => { mounted = true; let start = Date.now(); let animate = () => { let progress = Math.min((Date.now() - start) / {{ $duration }}, 1); count = Math.round(progress * target); if (progress < 1) requestAnimationFrame(animate); }; animate(); }, 100)"
>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="mounted ? {{ $offset }} : {{ $circumference }}" class="transition-none" />
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center z-20"><span class="font-bold text-zinc-900 dark:text-white tabular-nums" style="font-size: {{ $sizePx / 4 }}px;" x-text="count + '%'"></span></div>@endif
    </div>
</div>
