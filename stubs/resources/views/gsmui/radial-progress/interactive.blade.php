@props([
    'value' => 50,
    'max' => 100,
    'min' => 0,
    'size' => 'md',
    'color' => 'blue',
    'label' => null,
    'showValue' => true,
    'step' => 1,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 12;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'red' => '#ef4444', 'purple' => '#a855f7', 'orange' => '#f97316'];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}
    x-data="{ 
        value: {{ $value }}, 
        min: {{ $min }}, 
        max: {{ $max }}, 
        step: {{ $step }},
        dragging: false,
        get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; },
        get offset() { return {{ $circumference }} - (this.percentage / 100) * {{ $circumference }}; }
    }"
>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative cursor-pointer" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;"
        @click="
            const rect = $el.getBoundingClientRect();
            const x = event.clientX - rect.left - rect.width / 2;
            const y = event.clientY - rect.top - rect.height / 2;
            let angle = Math.atan2(y, x) * (180 / Math.PI) + 90;
            if (angle < 0) angle += 360;
            const newValue = Math.round((angle / 360) * (max - min) + min);
            value = Math.min(max, Math.max(min, Math.round(newValue / step) * step));
        "
    >
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="offset" class="transition-all duration-150" />
            {{-- Thumb --}}
            @php
                $thumbAngle = ($percentage / 100) * 360 - 90;
                $thumbX = $sizePx / 2 + $radius * cos(deg2rad($thumbAngle));
                $thumbY = $sizePx / 2 + $radius * sin(deg2rad($thumbAngle));
            @endphp
            <circle :cx="{{ $sizePx / 2 }} + {{ $radius }} * Math.cos((percentage / 100 * 360 - 90) * Math.PI / 180)" :cy="{{ $sizePx / 2 }} + {{ $radius }} * Math.sin((percentage / 100 * 360 - 90) * Math.PI / 180)" r="10" fill="white" stroke="{{ $trackColor }}" stroke-width="3" class="cursor-grab active:cursor-grabbing" />
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center pointer-events-none"><span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 4 }}px;" x-text="Math.round(value) + '%'"></span></div>@endif
    </div>
    <div class="flex gap-2">
        <button @click="value = Math.max(min, value - step)" class="px-3 py-1 text-sm bg-zinc-200 dark:bg-zinc-700 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600">-</button>
        <button @click="value = Math.min(max, value + step)" class="px-3 py-1 text-sm bg-zinc-200 dark:bg-zinc-700 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600">+</button>
    </div>
</div>
