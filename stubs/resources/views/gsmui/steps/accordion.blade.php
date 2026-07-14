@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'multiple' => false,
])

@php
$colors = [
    'blue' => ['active' => 'border-blue-500 bg-blue-50 dark:bg-blue-500/10', 'badge' => 'bg-blue-500 text-white'],
    'green' => ['active' => 'border-green-500 bg-green-50 dark:bg-green-500/10', 'badge' => 'bg-green-500 text-white'],
    'purple' => ['active' => 'border-purple-500 bg-purple-50 dark:bg-purple-500/10', 'badge' => 'bg-purple-500 text-white'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['space-y-2']) }} x-data="{ openStep: {{ $current }} }">
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
        @endphp
        
        <div class="border rounded-lg overflow-hidden transition-all duration-300 {{ $isActive ? $colorSet['active'] . ' border-l-4' : 'border-zinc-200 dark:border-zinc-700' }}">
            <button 
                type="button"
                class="w-full px-4 py-3 flex items-center justify-between text-left focus:outline-none"
                @click="openStep = openStep === {{ $stepNumber }} ? null : {{ $stepNumber }}"
            >
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-semibold {{ $isCompleted ? $colorSet['badge'] : ($isActive ? $colorSet['badge'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                        @if($isCompleted)
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @else
                            {{ $stepNumber }}
                        @endif
                    </div>
                    
                    <span class="text-sm font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-700 dark:text-zinc-300' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                </div>
                
                <svg class="w-5 h-5 text-zinc-500 transition-transform duration-200" :class="openStep === {{ $stepNumber }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            
            <div x-show="openStep === {{ $stepNumber }}" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-0">
                    @if(isset($step['content']))
                        {{ $step['content'] }}
                    @else
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $step['description'] ?? 'Step content goes here.' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
