@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'showPercentage' => true,
])

@php
$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
];
$colorClass = $colors[$color] ?? 'bg-blue-500';
$percentage = count($steps) > 0 ? (($current - 1) / (count($steps) - 1)) * 100 : 0;
@endphp

<div {{ $attributes->class(['select-none']) }}>
    {{-- Progress header --}}
    <div class="flex items-center justify-between mb-4">
        <div class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
            Step {{ $current }} of {{ count($steps) }}
        </div>
        @if($showPercentage)
            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                {{ round($percentage) }}%
            </div>
        @endif
    </div>
    
    {{-- Progress bar --}}
    <div class="w-full h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden mb-6">
        <div class="h-full {{ $colorClass }} transition-all duration-500 ease-out" 
             style="width: {{ $percentage }}%"></div>
    </div>
    
    {{-- Step indicators --}}
    <div class="flex items-center justify-between">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp
            
            <div class="flex flex-col items-center">
                <div 
                    class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold transition-all duration-300
                    {{ $isActive ? $colorClass . ' text-white scale-110' : ($isCompleted ? $colorClass . ' text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}"
                >
                    @if($isCompleted)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
                
                <div class="mt-2 text-center">
                    <span class="text-xs font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- Current step content --}}
    @if(isset($steps[$current - 1]['content']))
        <div class="mt-8 p-6 bg-zinc-50 dark:bg-zinc-800 rounded-xl">
            {{ $steps[$current - 1]['content'] }}
        </div>
    @endif
</div>
