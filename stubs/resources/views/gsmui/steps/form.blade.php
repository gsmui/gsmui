@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'prevLabel' => 'Back',
    'nextLabel' => 'Continue',
    'submitLabel' => 'Submit',
])

@php
$colors = [
    'blue' => ['bg' => 'bg-blue-500', 'ring' => 'ring-blue-500/30'],
    'green' => ['bg' => 'bg-green-500', 'ring' => 'ring-green-500/30'],
    'purple' => ['bg' => 'bg-purple-500', 'ring' => 'ring-purple-500/30'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
$totalSteps = count($steps);
@endphp

<div {{ $attributes->class(['bg-white dark:bg-zinc-800 rounded-2xl shadow-lg overflow-hidden']) }}
     x-data="{ step: {{ $current }}, total: {{ $totalSteps }} }">
    
    {{-- Progress bar --}}
    <div class="h-1 bg-zinc-200 dark:bg-zinc-700">
        <div class="h-full {{ $colorSet['bg'] }} transition-all duration-500 ease-out"
             :style="`width: ${(step / total) * 100}%`"></div>
    </div>
    
    {{-- Step indicators --}}
    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
        <div class="flex items-center justify-between">
            @foreach($steps as $index => $stepItem)
                @php $stepNumber = $index + 1; @endphp
                <div class="flex items-center {{ $index < $totalSteps - 1 ? 'flex-1' : '' }}">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300"
                             :class="step === {{ $stepNumber }} ? '{{ $colorSet['bg'] }} text-white ring-4 {{ $colorSet['ring'] }}' : (step > {{ $stepNumber }} ? '{{ $colorSet['bg'] }} text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500')">
                            @if($stepNumber < $current)
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            @else
                                {{ $stepNumber }}
                            @endif
                        </div>
                        <span class="text-sm font-medium hidden sm:block" :class="step >= {{ $stepNumber }} ? 'text-zinc-900 dark:text-white' : 'text-zinc-400'">
                            {{ $stepItem['title'] ?? 'Step ' . $stepNumber }}
                        </span>
                    </div>
                    @if($index < $totalSteps - 1)
                        <div class="flex-1 mx-4 h-0.5 transition-colors duration-300" :class="step > {{ $stepNumber }} ? '{{ $colorSet['bg'] }}' : 'bg-zinc-200 dark:bg-zinc-700'"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- Step content --}}
    <div class="p-6 min-h-[300px]">
        @foreach($steps as $index => $stepItem)
            @php $stepNumber = $index + 1; @endphp
            <div x-show="step === {{ $stepNumber }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                @if(isset($stepItem['content']))
                    {{ $stepItem['content'] }}
                @else
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $stepItem['title'] ?? 'Step ' . $stepNumber }}</h3>
                        @if(isset($stepItem['description']))
                            <p class="text-zinc-500 dark:text-zinc-400">{{ $stepItem['description'] }}</p>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    {{-- Navigation --}}
    <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
        <button @click="step = Math.max(1, step - 1)" x-show="step > 1"
                class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors">
            {{ $prevLabel }}
        </button>
        <div x-show="step <= 1"></div>
        <button @click="step = Math.min(total, step + 1)" x-show="step < total"
                class="px-4 py-2 text-sm font-medium text-white {{ $colorSet['bg'] }} rounded-lg hover:opacity-90 transition-opacity">
            {{ $nextLabel }}
        </button>
        <button x-show="step === total"
                class="px-4 py-2 text-sm font-medium text-white bg-emerald-500 rounded-lg hover:bg-emerald-600 transition-colors">
            {{ $submitLabel }}
        </button>
    </div>
</div>
