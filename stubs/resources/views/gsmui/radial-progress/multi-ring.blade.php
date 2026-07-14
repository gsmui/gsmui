@props([
    'rings' => [
        ['value' => 80, 'color' => '#3b82f6', 'label' => 'Sales'],
        ['value' => 60, 'color' => '#22c55e', 'label' => 'Revenue'],
        ['value' => 40, 'color' => '#f97316', 'label' => 'Profit'],
    ],
    'max' => 100,
    'size' => 'lg',
    'showValue' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['lg'];
    $center = $sizePx / 2;
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            @foreach($rings as $index => $ring)
                @php
                    $ringRadius = $center - 10 - ($index * 15);
                    $ringCircumference = 2 * pi() * $ringRadius;
                    $ringPercentage = $max > 0 ? min(100, max(0, ($ring['value'] / $max) * 100)) : 0;
                    $ringOffset = $ringCircumference - ($ringPercentage / 100) * $ringCircumference;
                @endphp
                <circle cx="{{ $center }}" cy="{{ $center }}" r="{{ $ringRadius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="8" />
                <circle cx="{{ $center }}" cy="{{ $center }}" r="{{ $ringRadius }}" fill="none" stroke="{{ $ring['color'] }}" stroke-width="8" stroke-linecap="round" :stroke-dasharray="{{ $ringCircumference }}" :stroke-dashoffset="{{ $ringOffset }}" class="transition-all duration-500" />
            @endforeach
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="text-lg font-bold text-zinc-900 dark:text-white">{{ round($rings[0]['value']) }}%</span></div>@endif
    </div>
    <div class="flex gap-3">
        @foreach($rings as $ring)
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 rounded-full" style="background-color: {{ $ring['color'] }};"></div>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">{{ $ring['label'] }}</span>
            </div>
        @endforeach
    </div>
</div>
