@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'showNavigation' => true,
    'prevLabel' => 'Previous',
    'nextLabel' => 'Next',
    'finishLabel' => 'Finish',
])

@php
    $colors = [
        'blue' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-500', 'ring' => 'ring-blue-500/30'],
        'green' => ['bg' => 'bg-green-500', 'text' => 'text-green-500', 'ring' => 'ring-green-500/30'],
        'purple' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-500', 'ring' => 'ring-purple-500/30'],
    ];
    $colorSet = $colors[$color] ?? $colors['blue'];
    $totalSteps = count($steps);
@endphp

<div {{ $attributes->class(["bg-white dark:bg-zinc-800 rounded-2xl shadow-lg overflow-hidden"]) }}
    x-data="{ current: {{ $current }}, total: {{ $totalSteps }} }"
>
    {{-- Progress Bar --}}
    <div class="h-1 bg-zinc-200 dark:bg-zinc-700">
        <div class="h-full {{ $colorSet['bg'] }} transition-all duration-500" :style="`width: ${(current / total) * 100}%`"></div>
    </div>

    {{-- Step Indicators --}}
    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
        <div class="flex items-center justify-between">
            @foreach($steps as $index => $step)
                @php $stepNumber = $index + 1; @endphp
                <div class="flex items-center {{ $index < $totalSteps - 1 ? 'flex-1' : '' }}">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300"
                            :class="current === {{ $stepNumber }} ? '{{ $colorSet['bg'] }} text-white ring-4 {{ $colorSet['ring'] }}' : (current > {{ $stepNumber }} ? '{{ $colorSet['bg'] }} text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500')">
                            @if($stepNumber < $current)
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            @else
                                {{ $stepNumber }}
                            @endif
                        </div>
                        <span class="text-sm font-medium hidden sm:block" :class="current >= {{ $stepNumber }} ? 'text-zinc-900 dark:text-white' : 'text-zinc-400'">{{ $step['title'] ?? 'Step' }}</span>
                    </div>
                    @if($index < $totalSteps - 1)
                        <div class="flex-1 mx-4 h-0.5 transition-colors duration-300" :class="current > {{ $stepNumber }} ? '{{ $colorSet['bg'] }}' : 'bg-zinc-200 dark:bg-zinc-700'"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Content --}}
    <div class="p-6 min-h-[300px]">
        @foreach($steps as $index => $step)
            @php $stepNumber = $index + 1; @endphp
            <div x-show="current === {{ $stepNumber }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                @if(isset($step['content']))
                    {{ $step['content'] }}
                @else
                    <div class="text-center py-12">
                        <div class="text-4xl mb-4">📝</div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $step['title'] ?? 'Step ' . $stepNumber }}</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 mt-2">{{ $step['description'] ?? 'Content for this step' }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Navigation --}}
    @if($showNavigation)
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
            <button @click="current = Math.max(1, current - 1)" x-show="current > 1" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors">
                {{ $prevLabel }}
            </button>
            <div x-show="current <= 1"></div>
            <button @click="current = Math.min(total, current + 1)" x-show="current < total" class="px-4 py-2 text-sm font-medium text-white {{ $colorSet['bg'] }} rounded-lg hover:opacity-90 transition-opacity">
                {{ $nextLabel }}
            </button>
            <button x-show="current === total" class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 transition-colors">
                {{ $finishLabel }}
            </button>
        </div>
    @endif
</div>
