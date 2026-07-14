@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'orientation' => 'horizontal',
])

@php
$colors = [
    'blue' => ['active' => 'bg-blue-500 text-white', 'line' => 'bg-blue-500', 'track' => 'bg-blue-100 dark:bg-blue-900/30'],
    'green' => ['active' => 'bg-green-500 text-white', 'line' => 'bg-green-500', 'track' => 'bg-green-100 dark:bg-green-900/30'],
    'purple' => ['active' => 'bg-purple-500 text-white', 'line' => 'bg-purple-500', 'track' => 'bg-purple-100 dark:bg-purple-900/30'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class([$orientation === 'vertical' ? 'flex' : '']) }}>
    <div class="{{ $orientation === 'vertical' ? 'flex flex-col' : 'flex items-center' }}">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp
            
            @if($orientation === 'horizontal')
                <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
            @else
                <div class="relative flex items-start {{ $index < count($steps) - 1 ? 'pb-8' : '' }}">
                    @if($index < count($steps) - 1)
                        <div class="absolute left-4 top-10 w-0.5 h-full {{ $isCompleted ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }}"></div>
                    @endif
            @endif
            
            <div class="flex {{ $orientation === 'horizontal' ? 'flex-col items-center' : 'items-center' }}">
                <div class="relative z-10 w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300 {{ $isActive ? $colorSet['active'] : ($isCompleted ? $colorSet['active'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                    @if($isCompleted)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
                
                <div class="{{ $orientation === 'horizontal' ? 'mt-2 text-center' : 'ml-4' }}">
                    <span class="text-sm font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                    @if(isset($step['description']))
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $step['description'] }}</p>
                    @endif
                </div>
            </div>
            
            @if($orientation === 'horizontal')
                @if(!$loop->last)
                    <div class="flex-1 mx-2 h-0.5 {{ $isCompleted ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300"></div>
                @endif
                </div>
            @else
                </div>
            @endif
        @endforeach
    </div>
</div>
