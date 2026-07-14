@props([
    'innerValue' => 60,
    'outerValue' => 80,
    'max' => 100,
    'size' => 'md',
    'innerColor' => '#3b82f6',
    'outerColor' => '#22c55e',
    'label' => null,
    'showValue' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $center = $sizePx / 2;
    $innerRadius = $center - 20;
    $outerRadius = $center - 8;
    $innerCircumference = 2 * pi() * $innerRadius;
    $outerCircumference = 2 * pi() * $outerRadius;
    $innerPercentage = $max > 0 ? min(100, max(0, ($innerValue / $max) * 100)) : 0;
    $outerPercentage = $max > 0 ? min(100, max(0, ($outerValue / $max) * 100)) : 0;
    $innerOffset = $innerCircumference - ($innerPercentage / 100) * $innerCircumference;
    $outerOffset = $outerCircumference - ($outerPercentage / 100) * $outerCircumference;
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            {{-- Outer track --}}
            <circle cx="{{ $center }}" cy="{{ $center }}" r="{{ $outerRadius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="8" />
            <circle cx="{{ $center }}" cy="{{ $center }}" r="{{ $outerRadius }}" fill="none" stroke="{{ $outerColor }}" stroke-width="8" stroke-linecap="round" :stroke-dasharray="{{ $outerCircumference }}" :stroke-dashoffset="{{ $outerOffset }}" class="transition-all duration-500" />
            {{-- Inner track --}}
            <circle cx="{{ $center }}" cy="{{ $center }}" r="{{ $innerRadius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="8" />
            <circle cx="{{ $center }}" cy="{{ $center }}" r="{{ $innerRadius }}" fill="none" stroke="{{ $innerColor }}" stroke-width="8" stroke-linecap="round" :stroke-dasharray="{{ $innerCircumference }}" :stroke-dashoffset="{{ $innerOffset }}" class="transition-all duration-500" />
        </svg>
        @if($showValue)
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-xl font-bold text-zinc-900 dark:text-white">{{ round($outerPercentage) }}%</span>
                <span class="text-xs text-zinc-500">/ {{ round($innerPercentage) }}%</span>
            </div>
        @endif
    </div>
</div>
