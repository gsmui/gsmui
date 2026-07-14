@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
    'markers' => [],
])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-emerald-500',
        'red' => 'bg-red-500',
        'purple' => 'bg-purple-500',
    ];
    $trackColor = $colors[$color] ?? $colors['blue'];
    $defaultMarkers = empty($markers) ? [
        ['value' => 0, 'label' => 'Min'],
        ['value' => 25, 'label' => '25%'],
        ['value' => 50, 'label' => 'Mid'],
        ['value' => 75, 'label' => '75%'],
        ['value' => 100, 'label' => 'Max'],
    ] : $markers;
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
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValue)
                <span class="text-lg font-bold text-zinc-900 dark:text-white" x-text="value"></span>
            @endif
        </div>
    @endif

    {{-- Markers --}}
    <div class="relative mb-3">
        @foreach($defaultMarkers as $marker)
            @php
                $markerPercentage = (($marker['value'] - $min) / ($max - $min)) * 100;
            @endphp
            <button 
                class="absolute -translate-x-1/2 flex flex-col items-center"
                :style="`left: {{ $markerPercentage }}%;`"
                @click="value = {{ $marker['value'] }}"
            >
                <span 
                    class="text-xs font-medium transition-colors"
                    :class="value >= {{ $marker['value'] }} ? 'text-zinc-900 dark:text-white' : 'text-zinc-400 dark:text-zinc-500'"
                >{{ $marker['label'] }}</span>
                <div class="w-0.5 h-2 bg-zinc-300 dark:bg-zinc-600 mt-1"></div>
            </button>
        @endforeach
    </div>

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

        @foreach($defaultMarkers as $marker)
            @php
                $markerPercentage = (($marker['value'] - $min) / ($max - $min)) * 100;
            @endphp
            <div 
                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-3 h-3 rounded-full border-2 border-white transition-colors"
                :class="value >= {{ $marker['value'] }} ? '{{ $trackColor }}' : 'bg-zinc-300 dark:bg-zinc-600'"
                :style="`left: {{ $markerPercentage }}%;`"
            ></div>
        @endforeach

        <div 
            class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab active:cursor-grabbing hover:scale-110 transition-transform z-10"
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
