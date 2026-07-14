@props([
    'value' => 0,
    'max' => 100,
    'size' => 'md',
    'label' => null,
    'showValue' => true,
    'stages' => [
        ['threshold' => 0, 'color' => '#ef4444', 'label' => 'Critical'],
        ['threshold' => 25, 'color' => '#f97316', 'label' => 'Low'],
        ['threshold' => 50, 'color' => '#eab308', 'label' => 'Medium'],
        ['threshold' => 75, 'color' => '#22c55e', 'label' => 'Good'],
        ['threshold' => 90, 'color' => '#3b82f6', 'label' => 'Excellent'],
    ],
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 12;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    
    $currentStage = $stages[0];
    foreach($stages as $stage) {
        if($percentage >= $stage['threshold']) {
            $currentStage = $stage;
        }
    }
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $currentStage['color'] }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" class="transition-all duration-500" />
        </svg>
        <div class="absolute inset-0 flex flex-col items-center justify-center">
            @if($showValue)<span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 4 }}px;">{{ round($percentage) }}%</span>@endif
            <span class="text-xs font-medium" style="color: {{ $currentStage['color'] }};">{{ $currentStage['label'] }}</span>
        </div>
    </div>
</div>
