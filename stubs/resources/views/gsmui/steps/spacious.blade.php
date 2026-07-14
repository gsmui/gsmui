@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'size' => 'lg',
])

@php
$sizes = [
    'md' => 'w-10 h-10 text-sm',
    'lg' => 'w-12 h-12 text-base',
    'xl' => 'w-14 h-14 text-lg',
];

$colors = [
    'blue' => ['active' => 'bg-blue-500 text-white', 'line' => 'bg-blue-500'],
    'green' => ['active' => 'bg-green-500 text-white', 'line' => 'bg-green-500'],
    'purple' => ['active' => 'bg-purple-500 text-white', 'line' => 'bg-purple-500'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['flex items-center gap-4']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
        @endphp
        
        <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center {{ $sizes[$size] }} rounded-full transition-all duration-300
                    {{ $isActive ? $colorSet['active'] . ' scale-110 shadow-lg' : ($isCompleted ? $colorSet['active'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                    @if($isCompleted)
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
                
                <div class="mt-4 text-center">
                    <span class="text-sm font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                    @if(isset($step['description']))
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 max-w-[120px]">{{ $step['description'] }}</p>
                    @endif
                </div>
            </div>
            
            @if(!$loop->last)
                <div class="flex-1 mx-6 h-0.5 {{ $isCompleted ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300"></div>
            @endif
        </div>
    @endforeach
</div>
