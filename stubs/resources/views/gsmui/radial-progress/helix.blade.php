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
$points = 12;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        {{-- Helix strands --}}
        @for($i = 0; $i < $points; $i++)
            @php
                $angle1 = ($i / $points) * 360;
                $angle2 = (($i + $points / 2) / $points) * 360;
                $rad1 = $angle1 * M_PI / 180;
                $rad2 = $angle2 * M_PI / 180;
                $x1 = $size / 2 + $radius * cos($rad1);
                $y1 = $size / 2 + $radius * sin($rad1);
                $x2 = $size / 2 + $radius * cos($rad2);
                $y2 = $size / 2 + $radius * sin($rad2);
                $isActive = ($i / $points) * 100 < $percentage;
            @endphp
            {{-- Connecting bar --}}
            <line x1="{{ $x1 }}" y1="{{ $y1 }}" x2="{{ $x2 }}" y2="{{ $y2 }}" 
                  stroke-width="1" class="{{ $isActive ? 'stroke-emerald-400' : 'stroke-zinc-300 dark:stroke-zinc-600' }}" opacity="0.3"
                  style="transition: stroke 0.3s ease-out;" />
            {{-- Strand dots --}}
            <circle cx="{{ $x1 }}" cy="{{ $y1 }}" r="{{ $isActive ? 4 : 2 }}" 
                    class="{{ $isActive ? 'fill-emerald-500' : 'fill-zinc-300 dark:fill-zinc-600' }}"
                    style="transition: all 0.3s ease-out {{ $i * 30 }}ms;" />
            <circle cx="{{ $x2 }}" cy="{{ $y2 }}" r="{{ $isActive ? 4 : 2 }}" 
                    class="{{ $isActive ? 'fill-teal-500' : 'fill-zinc-300 dark:fill-zinc-600' }}"
                    style="transition: all 0.3s ease-out {{ $i * 30 }}ms;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
