@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'w-8 h-8 text-xs',
    'md' => 'w-10 h-10 text-sm',
    'lg' => 'w-12 h-12 text-base',
];

$colors = [
    'blue' => ['active' => 'bg-blue-500/20 text-blue-600 dark:text-blue-400 border border-blue-500/30 backdrop-blur-md', 'line' => 'bg-blue-500/30'],
    'green' => ['active' => 'bg-green-500/20 text-green-600 dark:text-green-400 border border-green-500/30 backdrop-blur-md', 'line' => 'bg-green-500/30'],
    'purple' => ['active' => 'bg-purple-500/20 text-purple-600 dark:text-purple-400 border border-purple-500/30 backdrop-blur-md', 'line' => 'bg-purple-500/30'],
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
                <div class="flex items-center justify-center {{ $sizes[$size] }} rounded-xl transition-all duration-300
                    {{ $isActive ? $colorSet['active'] . ' shadow-lg' : ($isCompleted ? $colorSet['active'] : 'bg-zinc-100/50 dark:bg-zinc-800/50 text-zinc-500 border border-zinc-200/50 dark:border-zinc-700/50 backdrop-blur-sm') }}">
                    @if($isCompleted)
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
                
                <div class="mt-2 text-center">
                    <span class="text-sm font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                </div>
            </div>
            
            @if(!$loop->last)
                <div class="flex-1 mx-4 h-0.5 rounded-full {{ $isCompleted ? $colorSet['line'] : 'bg-zinc-200/50 dark:bg-zinc-700/50' }} transition-colors duration-300"></div>
            @endif
        </div>
    @endforeach
</div>
