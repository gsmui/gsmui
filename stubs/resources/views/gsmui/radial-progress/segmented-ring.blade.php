@props([
    'value' => 0,
    'max' => 100,
    'segments' => 8,
    'size' => 'md',
    'color' => 'blue',
    'label' => null,
    'showValue' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 12;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
    $segmentAngle = 360 / $segments;
    $gapAngle = 8;
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'red' => '#ef4444', 'purple' => '#a855f7'];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            @for($i = 0; $i < $segments; $i++)
                @php
                    $startAngle = $i * $segmentAngle;
                    $endAngle = $startAngle + $segmentAngle - $gapAngle;
                    $startRad = deg2rad($startAngle);
                    $endRad = deg2rad($endAngle);
                    $x1 = $sizePx / 2 + $radius * cos($startRad);
                    $y1 = $sizePx / 2 + $radius * sin($startRad);
                    $x2 = $sizePx / 2 + $radius * cos($endRad);
                    $y2 = $sizePx / 2 + $radius * sin($endRad);
                    $isActive = $i < ceil(($percentage / 100) * $segments);
                @endphp
                <path d="M {{ $x1 }} {{ $y1 }} A {{ $radius }} {{ $radius }} 0 0 1 {{ $x2 }} {{ $y2 }}" fill="none" stroke="{{ $isActive ? $trackColor : 'currentColor' }}" class="{{ $isActive ? '' : 'text-zinc-200 dark:text-zinc-700' }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" />
            @endfor
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 4 }}px;">{{ round($percentage) }}%</span></div>@endif
    </div>
</div>
