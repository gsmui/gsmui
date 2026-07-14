@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'color' => 'blue',
    'tooltipAlways' => false,
    'prefix' => '',
    'suffix' => '',
])

@php
    $colors = [
        'blue' => ['track' => 'bg-blue-500', 'thumb' => 'border-blue-500', 'tooltip' => 'bg-blue-600'],
        'green' => ['track' => 'bg-emerald-500', 'thumb' => 'border-emerald-500', 'tooltip' => 'bg-emerald-600'],
        'red' => ['track' => 'bg-red-500', 'thumb' => 'border-red-500', 'tooltip' => 'bg-red-600'],
        'purple' => ['track' => 'bg-purple-500', 'thumb' => 'border-purple-500', 'tooltip' => 'bg-purple-600'],
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
        dragging: false,
        get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; }
    }"
>
    @if($label)
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
        </div>
    @endif

    <div class="pt-6 pb-2">
        <div 
            class="relative h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full cursor-pointer"
            @click="
                const rect = $el.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                value = Math.round((x * (max - min) + min) / step) * step;
                value = Math.min(max, Math.max(min, value));
            "
            @mousedown="dragging = true"
            @mouseup="dragging = false"
            @mouseleave="dragging = false"
        >
            <div class="absolute h-full {{ $colorSet['track'] }} rounded-full" :style="`width: ${percentage}%;`"></div>

            {{-- Tooltip --}}
            <div 
                class="absolute -top-2 -translate-x-1/2 transition-all duration-150"
                :class="dragging || {{ $tooltipAlways ? 'true' : 'false' }} ? 'opacity-100 scale-100' : 'opacity-0 scale-75'"
                :style="`left: ${percentage}%;`"
            >
                <div class="relative">
                    <div class="{{ $colorSet['tooltip'] }} text-white text-xs font-bold px-2 py-1 rounded-lg shadow-lg whitespace-nowrap">
                        {{ $prefix }}<span x-text="value"></span>{{ $suffix }}
                    </div>
                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-current {{ $colorSet['tooltip'] }}"></div>
                </div>
            </div>

            {{-- Thumb --}}
            <div 
                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-4 {{ $colorSet['thumb'] }} shadow-lg cursor-grab active:cursor-grabbing hover:scale-110 transition-transform"
                :style="`left: ${percentage}%;`"
                @mousedown.stop="
                    const rect = $el.parentElement.getBoundingClientRect();
                    const onMove = (e) => {
                        const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                        value = Math.round((x * (max - min) + min) / step) * step;
                        value = Math.min(max, Math.max(min, value));
                    };
                    const onUp = () => { dragging = false; document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
                    dragging = true;
                    document.addEventListener('mousemove', onMove);
                    document.addEventListener('mouseup', onUp);
                "
            ></div>
        </div>
    </div>
</div>
