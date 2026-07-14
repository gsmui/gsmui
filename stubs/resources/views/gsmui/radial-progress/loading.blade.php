@props([
    'size' => 'md',
    'color' => 'blue',
    'label' => null,
    'text' => 'Loading...',
])

@php
    $sizes = ['xs' => 24, 'sm' => 32, 'md' => 48, 'lg' => 64, 'xl' => 96];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = $sizePx / 8;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'red' => '#ef4444', 'purple' => '#a855f7', 'white' => '#ffffff'];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["inline-flex items-center gap-3 select-none"]) }}>
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90 animate-spin" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}" style="animation-duration: 1s;">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-dasharray="{{ $circumference * 0.75 }} {{ $circumference * 0.25 }}" />
        </svg>
    </div>
    @if($text)<span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $text }}</span>@endif
</div>
