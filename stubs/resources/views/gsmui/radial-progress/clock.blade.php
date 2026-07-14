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
$hourAngle = ($percentage / 100) * 360;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        {{-- Clock face --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-200 dark:stroke-zinc-700" />
        
        {{-- Hour markers --}}
        @for($i = 0; $i < 12; $i++)
            @php
                $markerAngle = ($i / 12) * 360 - 90;
                $markerRad = $markerAngle * M_PI / 180;
                $markerInner = $radius - 8;
                $markerOuter = $radius - 2;
                $x1 = $size / 2 + $markerInner * cos($markerRad);
                $y1 = $size / 2 + $markerInner * sin($markerRad);
                $x2 = $size / 2 + $markerOuter * cos($markerRad);
                $y2 = $size / 2 + $markerOuter * sin($markerRad);
            @endphp
            <line x1="{{ $x1 }}" y1="{{ $y1 }}" x2="{{ $x2 }}" y2="{{ $y2 }}" 
                  stroke-width="2" class="stroke-zinc-400 dark:stroke-zinc-500" />
        @endfor
        
        {{-- Clock hand --}}
        @php
            $handAngle = ($percentage / 100) * 360 - 90;
            $handRad = $handAngle * M_PI / 180;
            $handLength = $radius * 0.6;
            $handX = $size / 2 + $handLength * cos($handRad);
            $handY = $size / 2 + $handLength * sin($handRad);
        @endphp
        <line x1="{{ $size / 2 }}" y1="{{ $size / 2 }}" x2="{{ $handX }}" y2="{{ $handY }}" 
              stroke-width="3" stroke-linecap="round"
              class="stroke-blue-500 dark:stroke-blue-400"
              style="transition: all 0.5s ease-out;" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="4" class="fill-blue-500 dark:fill-blue-400" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
