@props([
    'ranges' => [
        ['label' => 'Range 1', 'min' => 0, 'max' => 100, 'value' => 30, 'color' => 'blue'],
        ['label' => 'Range 2', 'min' => 0, 'max' => 100, 'value' => 60, 'color' => 'green'],
        ['label' => 'Range 3', 'min' => 0, 'max' => 100, 'value' => 80, 'color' => 'purple'],
    ],
    'step' => 1,
    'showValues' => true,
])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-emerald-500',
        'red' => 'bg-red-500',
        'purple' => 'bg-purple-500',
        'orange' => 'bg-orange-500',
    ];
@endphp

<div 
    {{ $attributes->class(["w-full select-none space-y-4"]) }}
    x-data="{ 
        ranges: {{ json_encode($ranges) }},
        step: {{ $step }}
    }"
>
    @foreach($ranges as $index => $range)
        @php
            $trackColor = $colors[$range['color']] ?? $colors['blue'];
        @endphp
        <div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $range['label'] }}</span>
                @if($showValues)
                    <span class="text-sm font-bold text-zinc-900 dark:text-white" x-text="ranges[{{ $index }}].value"></span>
                @endif
            </div>
            <div 
                class="relative h-3 bg-zinc-200 dark:bg-zinc-700 rounded-full cursor-pointer"
                @click="
                    const rect = $el.getBoundingClientRect();
                    ranges[{{ $index }}].value = Math.round(((event.clientX - rect.left) / rect.width * (ranges[{{ $index }}].max - ranges[{{ $index }}].min) + ranges[{{ $index }}].min) / step) * step;
                    ranges[{{ $index }}].value = Math.min(ranges[{{ $index }}].max, Math.max(ranges[{{ $index }}].min, ranges[{{ $index }}].value));
                "
            >
                <div class="absolute h-full {{ $trackColor }} rounded-full transition-all duration-150" :style="`width: ${(ranges[{{ $index }}].value - ranges[{{ $index }}].min) / (ranges[{{ $index }}].max - ranges[{{ $index }}].min) * 100}%;`"></div>
                <div 
                    class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab hover:scale-110 transition-transform"
                    :style="`left: ${(ranges[{{ $index }}].value - ranges[{{ $index }}].min) / (ranges[{{ $index }}].max - ranges[{{ $index }}].min) * 100}%;`"
                    @mousedown.stop="
                        const rect = $el.parentElement.getBoundingClientRect();
                        const idx = {{ $index }};
                        const onMove = (e) => {
                            const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                            ranges[idx].value = Math.round((x * (ranges[idx].max - ranges[idx].min) + ranges[idx].min) / step) * step;
                            ranges[idx].value = Math.min(ranges[idx].max, Math.max(ranges[idx].min, ranges[idx].value));
                        };
                        const onUp = () => { document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
                        document.addEventListener('mousemove', onMove);
                        document.addEventListener('mouseup', onUp);
                    "
                ></div>
            </div>
        </div>
    @endforeach
</div>
