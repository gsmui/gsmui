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
$petals = 6;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        {{-- Petals --}}
        @for($i = 0; $i < $petals; $i++)
            @php
                $angle = ($i / $petals) * 360;
                $rad = $angle * M_PI / 180;
                $petalX = $size / 2 + ($radius * 0.5) * cos($rad);
                $petalY = $size / 2 + ($radius * 0.5) * sin($rad);
                $isActive = ($i / $petals) * 100 < $percentage;
            @endphp
            <circle cx="{{ $petalX }}" cy="{{ $petalY }}" r="{{ $radius * 0.25 }}" 
                    class="{{ $isActive ? 'fill-fuchsia-400 dark:fill-fuchsia-500' : 'fill-zinc-200 dark:fill-zinc-700' }}"
                    opacity="{{ $isActive ? 0.6 : 0.3 }}"
                    style="transition: all 0.3s ease-out {{ $i * 50 }}ms;" />
        @endfor
        
        {{-- Center --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius * 0.15 }}" 
                class="fill-amber-400 dark:fill-amber-300" />
        
        {{-- Progress ring --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth * 0.5 }}" 
                class="stroke-fuchsia-200 dark:stroke-fuchsia-800"
                transform="rotate(-90 {{ $size / 2 }} {{ $size / 2 }})" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth * 0.5 }}" 
                stroke-linecap="round"
                class="stroke-fuchsia-500 dark:stroke-fuchsia-400"
                transform="rotate(-90 {{ $size / 2 }} {{ $size / 2 }})"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-fuchsia-600 dark:text-fuchsia-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
