@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'clickable' => true,
])

@php
$colors = [
    'blue' => ['active' => 'bg-blue-500 text-white', 'line' => 'bg-blue-500', 'hover' => 'hover:bg-blue-100 dark:hover:bg-blue-900/30'],
    'green' => ['active' => 'bg-green-500 text-white', 'line' => 'bg-green-500', 'hover' => 'hover:bg-green-100 dark:hover:bg-green-900/30'],
    'purple' => ['active' => 'bg-purple-500 text-white', 'line' => 'bg-purple-500', 'hover' => 'hover:bg-purple-100 dark:hover:bg-purple-900/30'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['select-none']) }} x-data="{ currentStep: {{ $current }} }">
    <div class="flex items-center">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
            @endphp
            
            <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
                <div class="flex flex-col items-center">
                    <button 
                        type="button"
                        class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300
                        {{ $clickable ? $colorSet['hover'] : '' }}"
                        :class="currentStep === {{ $stepNumber }} ? '{{ $colorSet['active'] }}' : (currentStep > {{ $stepNumber }} ? '{{ $colorSet['active'] }}' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500')"
                        @if($clickable) @click="currentStep = {{ $stepNumber }}" @endif
                    >
                        <template x-if="currentStep > {{ $stepNumber }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </template>
                        <template x-if="currentStep <= {{ $stepNumber }}">
                            <span x-text="{{ $stepNumber }}"></span>
                        </template>
                    </button>
                    
                    <div class="mt-2 text-center">
                        <span class="text-sm font-medium" :class="currentStep === {{ $stepNumber }} ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400'">
                            {{ $step['title'] ?? 'Step ' . $stepNumber }}
                        </span>
                    </div>
                </div>
                
                @if(!$loop->last)
                    <div class="flex-1 mx-4 h-1 rounded-full transition-colors duration-300" :class="currentStep > {{ $stepNumber }} ? '{{ $colorSet['line'] }}' : 'bg-zinc-200 dark:bg-zinc-700'"></div>
                @endif
            </div>
        @endforeach
    </div>
    
    {{-- Content area --}}
    <div class="mt-8">
        @foreach($steps as $index => $step)
            @php $stepNumber = $index + 1; @endphp
            <div x-show="currentStep === {{ $stepNumber }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                @if(isset($step['content']))
                    {{ $step['content'] }}
                @else
                    <div class="p-6 bg-zinc-50 dark:bg-zinc-800 rounded-xl text-center">
                        <div class="text-4xl mb-4">{{ $step['icon'] ?? '📝' }}</div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $step['title'] ?? 'Step ' . $stepNumber }}</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 mt-2">{{ $step['description'] ?? 'Content for this step' }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
