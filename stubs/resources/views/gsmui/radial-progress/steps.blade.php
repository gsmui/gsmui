@props([
    'value' => 2,
    'steps' => 5,
    'size' => 'md',
    'color' => 'blue',
    'label' => null,
    'showValue' => true,
])

@php
    $sizes = ['sm' => 100, 'md' => 140, 'lg' => 180, 'xl' => 220];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 12;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $steps > 0 ? min(100, max(0, ($value / $steps) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'purple' => '#a855f7', 'orange' => '#f97316'];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-3 select-none"]) }}>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" class="transition-all duration-500" />
            {{-- Step markers --}}
            @for($i = 0; $i < $steps; $i++)
                @php
                    $angle = ($i / $steps) * 360 - 90;
                    $x = $sizePx / 2 + $radius * cos(deg2rad($angle));
                    $y = $sizePx / 2 + $radius * sin(deg2rad($angle));
                    $isCompleted = $i < $value;
                @endphp
                <circle cx="{{ $x }}" cy="{{ $y }}" r="6" fill="{{ $isCompleted ? $trackColor : 'white' }}" stroke="{{ $trackColor }}" stroke-width="2" class="transition-all duration-300" />
            @endfor
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 5 }}px;">{{ $value }}/{{ $steps }}</span></div>@endif
    </div>
</div>
