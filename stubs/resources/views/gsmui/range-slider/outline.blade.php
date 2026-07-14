@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
])

@php
    $colors = [
        'blue' => ['fill' => 'bg-blue-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500'],
        'green' => ['fill' => 'bg-emerald-500', 'border' => 'border-emerald-500', 'text' => 'text-emerald-500'],
        'red' => ['fill' => 'bg-red-500', 'border' => 'border-red-500', 'text' => 'text-red-500'],
        'purple' => ['fill' => 'bg-purple-500', 'border' => 'border-purple-500', 'text' => 'text-purple-500'],
    ];
    $colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ 
        value: {{ $value }}, 
        min: {{ $min }}, 
        max: {{ $max }}, 
        step: {{ $step }},
        get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; }
    }"
>
    @if($label)
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValue)
                <span class="text-lg font-bold {{ $colorSet['text'] }}" x-text="value"></span>
            @endif
        </div>
    @endif

    <div 
        class="relative h-3 rounded-full border-2 border-zinc-300 dark:border-zinc-600 cursor-pointer bg-transparent"
        @click="
            const rect = $el.getBoundingClientRect();
            const x = (event.clientX - rect.left) / rect.width;
            value = Math.round((x * (max - min) + min) / step) * step;
            value = Math.min(max, Math.max(min, value));
        "
    >
        <div class="absolute inset-y-0 left-0 {{ $colorSet['fill'] }} rounded-full opacity-30" :style="`width: ${percentage}%;`"></div>
        <div class="absolute inset-y-0 left-0 border-2 {{ $colorSet['border'] }} rounded-full bg-transparent" :style="`width: ${percentage}%;`"></div>

        <div 
            class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-4 {{ $colorSet['border'] }} shadow-lg cursor-grab active:cursor-grabbing hover:scale-110 transition-transform"
            :style="`left: ${percentage}%;`"
            @mousedown.stop="
                const rect = $el.parentElement.getBoundingClientRect();
                const onMove = (e) => {
                    const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                    value = Math.round((x * (max - min) + min) / step) * step;
                    value = Math.min(max, Math.max(min, value));
                };
                const onUp = () => { document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
                document.addEventListener('mousemove', onMove);
                document.addEventListener('mouseup', onUp);
            "
        ></div>
    </div>
</div>
