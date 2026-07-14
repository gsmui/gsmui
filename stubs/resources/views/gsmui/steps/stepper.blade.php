@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'showLabels' => true,
])

@php
$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
];
$colorClass = $colors[$color] ?? 'bg-blue-500';
@endphp

<div {{ $attributes->class(['flex items-center gap-4']) }}>
    {{-- Previous button --}}
    <button 
        class="w-10 h-10 rounded-full flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
        @if($current <= 1) disabled @endif
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    
    {{-- Step indicators --}}
    <div class="flex items-center gap-2">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp
            
            <div class="flex flex-col items-center">
                <div 
                    class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300
                    {{ $isActive ? $colorClass . ' text-white scale-110 shadow-lg' : ($isCompleted ? $colorClass . ' text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}"
                >
                    @if($isCompleted)
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
                
                @if($showLabels)
                    <div class="mt-2 text-center">
                        <span class="text-xs font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                            {{ $step['title'] ?? 'Step ' . $stepNumber }}
                        </span>
                    </div>
                @endif
            </div>
            
            @if(!$loop->last)
                <div class="w-12 h-0.5 mx-2 {{ $stepNumber < $current ? $colorClass : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300"></div>
            @endif
        @endforeach
    </div>
    
    {{-- Next button --}}
    <button 
        class="w-10 h-10 rounded-full flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
        @if($current >= count($steps)) disabled @endif
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
</div>
