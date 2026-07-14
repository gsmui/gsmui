@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
    'thumbType' => 'icon', // icon, image, text
    'thumbIcon' => 'star',
    'thumbText' => '★',
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
                <span class="text-lg font-bold text-zinc-900 dark:text-white" x-text="value"></span>
            @endif
        </div>
    @endif

    <div class="relative py-4">
        <div 
            class="relative h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full cursor-pointer"
            @click="
                const rect = $el.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                value = Math.round((x * (max - min) + min) / step) * step;
                value = Math.min(max, Math.max(min, value));
            "
        >
            <div class="absolute h-full {{ $trackColor }} rounded-full" :style="`width: ${percentage}%;`"></div>

            <div 
                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-10 h-10 {{ $trackColor }} rounded-full shadow-xl cursor-grab active:cursor-grabbing hover:scale-110 transition-transform flex items-center justify-center text-white font-bold"
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
            >
                @if($thumbType === 'text')
                    <span class="text-lg">{{ $thumbText }}</span>
                @else
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                @endif
            </div>
        </div>
    </div>
</div>
