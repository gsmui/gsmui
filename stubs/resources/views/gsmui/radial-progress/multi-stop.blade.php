@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'strokeWidth' => 8,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$radius = ($size - $strokeWidth) / 2;
$circumference = 2 * M_PI * $radius;
$offset = $circumference - ($percentage / 100) * $circumference;
$stops = [
    ['offset' => 0, 'color' => '#22c55e', 'threshold' => 0],
    ['offset' => 25, 'color' => '#3b82f6', 'threshold' => 25],
    ['offset' => 50, 'color' => '#a855f7', 'threshold' => 50],
    ['offset' => 75, 'color' => '#f43f5e', 'threshold' => 75],
];
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <defs>
            @foreach($stops as $i => $stop)
                <linearGradient id="stop-gradient-{{ $i }}" gradientUnits="userSpaceOnUse"
                                x1="{{ $size * 0.1 }}" y1="{{ $size / 2 }}" x2="{{ $size * 0.9 }}" y2="{{ $size / 2 }}">
                    <stop offset="0%" stop-color="{{ $stop['color'] }}" />
                    <stop offset="100%" stop-color="{{ $stops[($i + 1) % count($stops)]['color'] }}" />
                </linearGradient>
            @endforeach
        </defs>
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-200 dark:stroke-zinc-700" />
        
        @foreach($stops as $i => $stop)
            @php
                $nextStop = $stops[($i + 1) % count($stops)];
                $segStart = $stop['threshold'] / 100;
                $segEnd = min(100, $nextStop['threshold'] / 100);
                $segLength = ($segEnd - $segStart) * $circumference;
                $segOffset = (1 - $segEnd) * $circumference;
                $isActive = $percentage >= $stop['threshold'];
            @endphp
            @if($isActive)
                <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                        fill="none" stroke-width="{{ $strokeWidth }}" 
                        stroke-linecap="butt"
                        stroke="url(#stop-gradient-{{ $i }})"
                        style="stroke-dasharray: {{ $segLength }} {{ $circumference - $segLength }}; stroke-dashoffset: {{ $segOffset }}; transition: all 0.3s ease-out;" />
            @endif
        @endforeach
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-zinc-700 dark:text-zinc-300">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
