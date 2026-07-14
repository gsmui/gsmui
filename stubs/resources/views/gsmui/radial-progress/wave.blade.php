@props([
    'value' => 0,
    'max' => 100,
    'size' => 'md',
    'color' => 'blue',
    'label' => null,
    'showValue' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 10;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'cyan' => '#06b6d4', 'purple' => '#a855f7'];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <defs>
                <clipPath id="wave-clip-{{ md5($attributes->getClasses() ?? '') }}">
                    <path d="M{{ $sizePx / 2 }} {{ $sizePx }} L0 {{ $sizePx }} L0 0 L{{ $sizePx }} 0 L{{ $sizePx }} {{ $sizePx }} Z">
                        <animate attributeName="d" dur="3s" repeatCount="indefinite" values="M{{ $sizePx / 2 }} {{ $sizePx }} L0 {{ $sizePx }} L0 {{ $sizePx / 2 }} Q{{ $sizePx / 4 }} {{ $sizePx / 2 - 10 }} {{ $sizePx / 2 }} {{ $sizePx / 2 }} Q{{ $sizePx * 3 / 4 }} {{ $sizePx / 2 + 10 }} {{ $sizePx }} {{ $sizePx / 2 }} L{{ $sizePx }} {{ $sizePx }} Z;M{{ $sizePx / 2 }} {{ $sizePx }} L0 {{ $sizePx }} L0 {{ $sizePx / 2 }} Q{{ $sizePx / 4 }} {{ $sizePx / 2 + 10 }} {{ $sizePx / 2 }} {{ $sizePx / 2 }} Q{{ $sizePx * 3 / 4 }} {{ $sizePx / 2 - 10 }} {{ $sizePx }} {{ $sizePx / 2 }} L{{ $sizePx }} {{ $sizePx }} Z;M{{ $sizePx / 2 }} {{ $sizePx }} L0 {{ $sizePx }} L0 {{ $sizePx / 2 }} Q{{ $sizePx / 4 }} {{ $sizePx / 2 - 10 }} {{ $sizePx / 2 }} {{ $sizePx / 2 }} Q{{ $sizePx * 3 / 4 }} {{ $sizePx / 2 + 10 }} {{ $sizePx }} {{ $sizePx / 2 }} L{{ $sizePx }} {{ $sizePx }} Z" />
                    </path>
                </clipPath>
            </defs>
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" class="transition-all duration-500" />
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 4 }}px;">{{ round($percentage) }}%</span></div>@endif
    </div>
</div>
