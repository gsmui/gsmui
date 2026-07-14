@props([
    'total' => 60,
    'value' => 30,
    'size' => 'md',
    'color' => 'blue',
    'label' => null,
    'showValue' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 8;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $total > 0 ? min(100, max(0, ($value / $total) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'red' => '#ef4444', 'purple' => '#a855f7', 'orange' => '#f97316'];
    $trackColor = $colors[$color] ?? $colors['blue'];
    $minutes = floor($value / 60);
    $seconds = $value % 60;
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}
    x-data="{ value: {{ $value }}, total: {{ $total }} }"
>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="({{ $total }} - value) / {{ $total }} * {{ $circumference }}" class="transition-all duration-1000" />
        </svg>
        @if($showValue)
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="font-bold text-zinc-900 dark:text-white tabular-nums" style="font-size: {{ $sizePx / 4 }}px;">
                    <span x-text="String(Math.floor(value / 60)).padStart(2, '0')"></span>:<span x-text="String(value % 60).padStart(2, '0')"></span>
                </span>
            </div>
        @endif
    </div>
    <div class="flex gap-2">
        <button @click="value = Math.min(total, value + 10)" class="px-2 py-1 text-xs bg-zinc-200 dark:bg-zinc-700 rounded hover:bg-zinc-300 dark:hover:bg-zinc-600">+10s</button>
        <button @click="value = Math.max(0, value - 10)" class="px-2 py-1 text-xs bg-zinc-200 dark:bg-zinc-700 rounded hover:bg-zinc-300 dark:hover:bg-zinc-600">-10s</button>
    </div>
</div>
