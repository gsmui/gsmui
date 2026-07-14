@props([
    'value' => 0,
    'max' => 100,
    'size' => 'md',
    'color' => 'blue',
    'title' => 'Progress',
    'description' => null,
    'stats' => [],
])

@php
    $sizes = ['sm' => 80, 'md' => 100, 'lg' => 120];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 8;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'red' => '#ef4444', 'purple' => '#a855f7'];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["bg-white dark:bg-zinc-800 rounded-2xl p-6 shadow-sm border border-zinc-200 dark:border-zinc-700 select-none"]) }}>
    <div class="flex items-start justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $title }}</h3>
            @if($description)<p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>@endif
        </div>
        <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
            <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
                <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-100 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
                <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" class="transition-all duration-500" />
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-lg font-bold text-zinc-900 dark:text-white">{{ round($percentage) }}%</span>
            </div>
        </div>
    </div>
    @if(count($stats) > 0)
        <div class="grid grid-cols-{{ count($stats) }} gap-4 pt-4 border-t border-zinc-100 dark:border-zinc-700">
            @foreach($stats as $stat)
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $stat['label'] ?? '' }}</p>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $stat['value'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
