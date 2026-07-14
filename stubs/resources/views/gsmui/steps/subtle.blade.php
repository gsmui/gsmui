@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'w-7 h-7 text-xs',
    'md' => 'w-9 h-9 text-sm',
    'lg' => 'w-11 h-11 text-base',
];

$colors = [
    'blue' => ['active' => 'text-blue-500', 'line' => 'text-blue-500'],
    'green' => ['active' => 'text-green-500', 'line' => 'text-green-500'],
    'purple' => ['active' => 'text-purple-500', 'line' => 'text-purple-500'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['flex items-center']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
        @endphp
        
        <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center {{ $sizes[$size] }} rounded-full transition-all duration-300
                    {{ $isActive ? $colorSet['active'] . ' font-semibold' : ($isCompleted ? $colorSet['active'] . ' opacity-50' : 'text-zinc-400 dark:text-zinc-600') }}">
                    @if($isCompleted)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
                
                <div class="mt-1 text-center">
                    <span class="text-xs font-medium {{ $isActive ? 'text-zinc-700 dark:text-zinc-300' : 'text-zinc-400 dark:text-zinc-600' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                </div>
            </div>
            
            @if(!$loop->last)
                <div class="flex-1 mx-3 h-px {{ $isCompleted ? 'bg-current ' . $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-800' }} transition-colors duration-300"></div>
            @endif
        </div>
    @endforeach
</div>
