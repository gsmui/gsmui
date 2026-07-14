@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
    'height' => '200px',
])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-emerald-500',
        'red' => 'bg-red-500',
        'purple' => 'bg-purple-500',
        'orange' => 'bg-orange-500',
    ];
    $trackColor = $colors[$color] ?? $colors['blue'];
    $percentage = (($value - $min) / ($max - $min)) * 100;
@endphp

<div 
    {{ $attributes->class(["relative inline-flex flex-col items-center gap-2 select-none"]) }}
    x-data="{ value: {{ $value }}, min: {{ $min }}, max: {{ $max }}, step: {{ $step }} }"
>
    @if($label)
        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
    @endif
    
    @if($showValue)
        <span class="text-sm font-bold text-zinc-900 dark:text-white" x-text="value"></span>
    @endif

    <div 
        class="relative w-3 rounded-full bg-zinc-200 dark:bg-zinc-700 cursor-pointer"
        style="height: {{ $height }};"
        @click="
            const rect = $el.getBoundingClientRect();
            const y = event.clientY - rect.top;
            const newValue = Math.round(((rect.height - y) / rect.height) * (max - min) + min);
            value = Math.min(max, Math.max(min, Math.round((newValue - min) / step) * step + min));
        "
        @mousedown="
            const rect = $el.getBoundingClientRect();
            const updateValue = (e) => {
                const y = Math.max(0, Math.min(rect.height, e.clientY - rect.top));
                const newValue = Math.round(((rect.height - y) / rect.height) * (max - min) + min);
                value = Math.min(max, Math.max(min, Math.round((newValue - min) / step) * step + min));
            };
            updateValue(event);
            const onMove = (e) => updateValue(e);
            const onUp = () => { document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
            document.addEventListener('mousemove', onMove);
            document.addEventListener('mouseup', onUp);
        "
    >
        <div class="absolute bottom-0 left-0 right-0 rounded-full {{ $trackColor }}" :style="`height: ${(value - min) / (max - min) * 100}%`"></div>
        <div 
            class="absolute left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-white border-2 border-zinc-300 shadow-md cursor-grab active:cursor-grabbing transition-transform hover:scale-110"
            :style="`bottom: calc(${(value - min) / (max - min) * 100}% - 10px);`"
            @mousedown.stop="
                const rect = $el.parentElement.getBoundingClientRect();
                const onMove = (e) => {
                    const y = Math.max(0, Math.min(rect.height, e.clientY - rect.top));
                    const newValue = Math.round(((rect.height - y) / rect.height) * (max - min) + min);
                    value = Math.min(max, Math.max(min, Math.round((newValue - min) / step) * step + min));
                };
                const onUp = () => { document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
                document.addEventListener('mousemove', onMove);
                document.addEventListener('mouseup', onUp);
            "
        ></div>
    </div>
</div>
