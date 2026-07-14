@props([
    'segments' => [
        ['value' => 30, 'color' => '#3b82f6'],
        ['value' => 25, 'color' => '#22c55e'],
        ['value' => 20, 'color' => '#f97316'],
        ['value' => 15, 'color' => '#a855f7'],
        ['value' => 10, 'color' => '#ef4444'],
    ],
    'max' => 100,
    'size' => 'md',
    'showValue' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 12;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $totalValue = collect($segments)->sum('value');
    $currentOffset = 0;
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            @foreach($segments as $segment)
                @php
                    $segmentPercentage = $totalValue > 0 ? ($segment['value'] / $totalValue) * 100 : 0;
                    $segmentLength = ($segmentPercentage / 100) * $circumference;
                    $gap = 4;
                    $dashArray = max(0, $segmentLength - $gap) . ' ' . ($circumference - max(0, $segmentLength - $gap));
                @endphp
                <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $segment['color'] }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $dashArray }}" :stroke-dashoffset="-{{ $currentOffset }}" class="transition-all duration-500" />
                @php $currentOffset += $segmentLength; @endphp
            @endforeach
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 4 }}px;">{{ $totalValue }}</span></div>@endif
    </div>
    <div class="flex flex-wrap gap-2 justify-center">
        @foreach($segments as $segment)
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 rounded-full" style="background-color: {{ $segment['color'] }};"></div>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">{{ $segment['value'] }}</span>
            </div>
        @endforeach
    </div>
</div>
