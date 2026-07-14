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
    'blue' => ['active' => 'bg-blue-500 text-white', 'line' => 'bg-blue-500', 'stripe' => 'bg-blue-400'],
    'green' => ['active' => 'bg-green-500 text-white', 'line' => 'bg-green-500', 'stripe' => 'bg-green-400'],
    'purple' => ['active' => 'bg-purple-500 text-white', 'line' => 'bg-purple-500', 'stripe' => 'bg-purple-400'],
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
                <div class="relative flex items-center justify-center {{ $sizes[$size] }} rounded-lg overflow-hidden transition-all duration-300
                    {{ $isActive ? $colorSet['active'] . ' shadow-lg' : ($isCompleted ? $colorSet['active'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                    
                    {{-- Striped background for completed --}}
                    @if($isCompleted)
                        <div class="absolute inset-0 opacity-20" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 2px, white 2px, white 4px);"></div>
                    @endif
                    
                    <div class="relative z-10">
                        @if($isCompleted)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @else
                            {{ $stepNumber }}
                        @endif
                    </div>
                </div>
                
                <div class="mt-2 text-center">
                    <span class="text-sm font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                </div>
            </div>
            
            @if(!$loop->last)
                <div class="flex-1 mx-4 h-1 relative overflow-hidden {{ $isCompleted ? '' : 'bg-zinc-200 dark:bg-zinc-700' }}">
                    @if($isCompleted)
                        <div class="absolute inset-0 {{ $colorSet['line'] }}" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 2px, white 2px, white 4px); opacity: 0.5;"></div>
                        <div class="absolute inset-0 {{ $colorSet['stripe'] }}"></div>
                    @endif
                </div>
            @endif
        </div>
    @endforeach
</div>
