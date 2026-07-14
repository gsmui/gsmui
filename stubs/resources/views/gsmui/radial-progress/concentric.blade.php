@props([
    'values' => [80, 60, 40],
    'colors' => ['#3b82f6', '#8b5cf6', '#ec4899'],
    'max' => 100,
    'size' => 'lg',
    'showValue' => true,
])

@php
    $sizes = ['md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['lg'];
    $center = $sizePx / 2;
    $maxRadius = $center - 10;
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            @foreach($values as $index => $value)
                @php
                    $ringRadius = $maxRadius - ($index * 20);
                    $ringCircumference = 2 * pi() * $ringRadius;
                    $ringPercentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
                    $ringOffset = $ringCircumference - ($ringPercentage / 100) * $ringCircumference;
                    $color = $colors[$index] ?? '#3b82f6';
                @endphp
                <circle cx="{{ $center }}" cy="{{ $center }}" r="{{ $ringRadius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="8" />
                <circle cx="{{ $center }}" cy="{{ $center }}" r="{{ $ringRadius }}" fill="none" stroke="{{ $color }}" stroke-width="8" stroke-linecap="round" :stroke-dasharray="{{ $ringCircumference }}" :stroke-dashoffset="{{ $ringOffset }}" class="transition-all duration-500" />
            @endforeach
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="text-xl font-bold text-zinc-900 dark:text-white">{{ round($values[0]) }}%</span></div>@endif
    </div>
</div>
