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
$angle = ($percentage / 100) * 360 - 90;
$rad = $angle * M_PI / 180;
$cometX = $size / 2 + $radius * cos($rad);
$cometY = $size / 2 + $radius * sin($rad);
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-slate-200 dark:stroke-slate-700" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="stroke-orange-500 dark:stroke-orange-400"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Comet head --}}
        <circle cx="{{ $cometX }}" cy="{{ $cometY }}" r="5" 
                class="fill-orange-400" 
                style="filter: drop-shadow(0 0 8px rgba(251, 146, 60, 0.8)); transition: all 0.5s ease-out;" />
        
        {{-- Comet tail --}}
        @for($i = 1; $i <= 5; $i++)
            @php
                $tailAngle = $angle - ($i * 8);
                $tailRad = $tailAngle * M_PI / 180;
                $tailX = $size / 2 + $radius * cos($tailRad);
                $tailY = $size / 2 + $radius * sin($tailRad);
                $tailOpacity = 0.6 - ($i * 0.1);
            @endphp
            <circle cx="{{ $tailX }}" cy="{{ $tailY }}" r="{{ 4 - $i * 0.5 }}" 
                    class="fill-orange-400" opacity="{{ $tailOpacity }}" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
