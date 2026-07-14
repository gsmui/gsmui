@props([
    'min' => 0,
    'max' => 100,
    'minValue' => 20,
    'maxValue' => 80,
    'step' => 1,
    'label' => null,
    'showValues' => true,
    'color' => 'blue',
])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-emerald-500',
        'red' => 'bg-red-500',
        'purple' => 'bg-purple-500',
    ];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ 
        minVal: {{ $minValue }}, 
        maxVal: {{ $maxValue }}, 
        min: {{ $min }}, 
        max: {{ $max }}, 
        step: {{ $step }},
        dragging: null,
        get minPercent() { return ((this.minVal - this.min) / (this.max - this.min)) * 100; },
        get maxPercent() { return ((this.maxVal - this.min) / (this.max - this.min)) * 100; }
    }"
>
    @if($label)
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValues)
                <span class="text-sm text-zinc-500">
                    <span x-text="minVal"></span> — <span x-text="maxVal"></span>
                </span>
            @endif
        </div>
    @endif

    <div 
        class="relative h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full"
        @mousedown="
            const rect = $el.getBoundingClientRect();
            const updateValues = (e) => {
                const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                const value = Math.round((x * (max - min) + min) / step) * step;
                const distToMin = Math.abs(value - minVal);
                const distToMax = Math.abs(value - maxVal);
                if (distToMin <= distToMax) {
                    minVal = Math.min(value, maxVal - step);
                } else {
                    maxVal = Math.max(value, minVal + step);
                }
            };
            updateValues(event);
        "
    >
        <div 
            class="absolute h-full {{ $trackColor }} rounded-full"
            :style="`left: ${minPercent}%; width: ${maxPercent - minPercent}%;`"
        ></div>

        {{-- Min Thumb --}}
        <div 
            class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab active:cursor-grabbing hover:scale-110 transition-transform z-10"
            :style="`left: ${minPercent}%;`"
            @mousedown.stop="
                dragging = 'min';
                const rect = $el.parentElement.getBoundingClientRect();
                const onMove = (e) => {
                    const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                    const value = Math.round((x * (max - min) + min) / step) * step;
                    minVal = Math.min(Math.max(value, min), maxVal - step);
                };
                const onUp = () => { dragging = null; document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
                document.addEventListener('mousemove', onMove);
                document.addEventListener('mouseup', onUp);
            "
        ></div>

        {{-- Max Thumb --}}
        <div 
            class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab active:cursor-grabbing hover:scale-110 transition-transform z-20"
            :style="`left: ${maxPercent}%;`"
            @mousedown.stop="
                dragging = 'max';
                const rect = $el.parentElement.getBoundingClientRect();
                const onMove = (e) => {
                    const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                    const value = Math.round((x * (max - min) + min) / step) * step;
                    maxVal = Math.max(Math.min(value, max), minVal + step);
                };
                const onUp = () => { dragging = null; document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
                document.addEventListener('mousemove', onMove);
                document.addEventListener('mouseup', onUp);
            "
        ></div>
    </div>

    @if(!$label && $showValues)
        <div class="flex justify-between mt-2 text-xs text-zinc-500">
            <span x-text="minVal"></span>
            <span x-text="maxVal"></span>
        </div>
    @endif
</div>
