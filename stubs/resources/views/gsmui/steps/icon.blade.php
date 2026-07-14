@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'w-8 h-8',
    'md' => 'w-10 h-10',
    'lg' => 'w-12 h-12',
];

$colors = [
    'blue' => ['active' => 'bg-blue-500 text-white', 'line' => 'bg-blue-500'],
    'green' => ['active' => 'bg-green-500 text-white', 'line' => 'bg-green-500'],
    'purple' => ['active' => 'bg-purple-500 text-white', 'line' => 'bg-purple-500'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['select-none']) }}>
    <div class="flex items-center">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp
            
            <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center {{ $sizes[$size] }} rounded-full transition-all duration-300
                        {{ $isActive ? $colorSet['active'] : ($isCompleted ? $colorSet['active'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                        @if($isCompleted)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @elseif(isset($step['icon']))
                            <span class="text-lg">{!! $step['icon'] !!}</span>
                        @else
                            {{ $stepNumber }}
                        @endif
                    </div>
                    
                    <div class="mt-3 text-center">
                        <div class="text-sm font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                            {{ $step['title'] ?? 'Step ' . $stepNumber }}
                        </div>
                        @if(isset($step['description']))
                            <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                {{ $step['description'] }}
                            </div>
                        @endif
                    </div>
                </div>
                
                @if(!$loop->last)
                    <div class="flex-1 mx-4 h-0.5 {{ $stepNumber < $current ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>
