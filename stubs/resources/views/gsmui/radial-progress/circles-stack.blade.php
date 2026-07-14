@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'strokeWidth' => 6,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$rings = [
    ['radius' => 0.48, 'color' => 'stroke-rose-500', 'bgColor' => 'stroke-rose-100 dark:stroke-rose-900/30', 'weight' => 0.3],
    ['radius' => 0.38, 'color' => 'stroke-amber-500', 'bgColor' => 'stroke-amber-100 dark:stroke-amber-900/30', 'weight' => 0.3],
    ['radius' => 0.28, 'color' => 'stroke-emerald-500', 'bgColor' => 'stroke-emerald-100 dark:stroke-emerald-900/30', 'weight' => 0.4],
];
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        @foreach($rings as $i => $ring)
            @php
                $r = $size * $ring['radius'];
                $circ = 2 * M_PI * $r;
                $ringPercentage = min(100, $percentage / $ring['weight']);
                $off = $circ - ($ringPercentage / 100) * $circ;
            @endphp
            <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $r }}" 
                    fill="none" stroke-width="{{ $strokeWidth }}" 
                    class="{{ $ring['bgColor'] }}" />
            <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $r }}" 
                    fill="none" stroke-width="{{ $strokeWidth }}" 
                    stroke-linecap="round"
                    class="{{ $ring['color'] }}"
                    style="stroke-dasharray: {{ $circ }}; stroke-dashoffset: {{ $off }}; transition: stroke-dashoffset 0.5s ease-out;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-zinc-700 dark:text-zinc-300">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
