@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        {{-- Outer ring --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $size * 0.48 }}" 
                fill="none" stroke-width="6" 
                class="{{ $percentage >= 25 ? 'stroke-red-500' : 'stroke-zinc-200 dark:stroke-zinc-700' }}"
                style="transition: all 0.3s ease-out;" />
        
        {{-- Second ring --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $size * 0.38 }}" 
                fill="none" stroke-width="6" 
                class="{{ $percentage >= 50 ? 'stroke-white dark:stroke-zinc-800 fill-white dark:fill-zinc-800' : 'stroke-zinc-200 dark:stroke-zinc-700 fill-zinc-200 dark:fill-zinc-700' }}"
                style="transition: all 0.3s ease-out;" />
        
        {{-- Third ring --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $size * 0.28 }}" 
                fill="none" stroke-width="6" 
                class="{{ $percentage >= 75 ? 'stroke-red-500' : 'stroke-zinc-200 dark:stroke-zinc-700' }}"
                style="transition: all 0.3s ease-out;" />
        
        {{-- Center --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $size * 0.12 }}" 
                class="{{ $percentage >= 100 ? 'fill-red-500' : 'fill-white dark:fill-zinc-800' }}"
                style="transition: all 0.3s ease-out;" />
        
        {{-- Arrow indicator --}}
        @if($percentage > 0)
            @php
                $arrowAngle = ($percentage / 100) * 360 - 90;
                $arrowRad = $arrowAngle * M_PI / 180;
                $arrowRadius = $size * 0.42;
                $arrowX = $size / 2 + $arrowRadius * cos($arrowRad);
                $arrowY = $size / 2 + $arrowRadius * sin($arrowRad);
            @endphp
            <circle cx="{{ $arrowX }}" cy="{{ $arrowY }}" r="4" 
                    class="fill-zinc-800 dark:fill-white"
                    style="transition: all 0.5s ease-out; filter: drop-shadow(0 0 2px rgba(0,0,0,0.3));" />
        @endif
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-zinc-700 dark:text-zinc-300">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
