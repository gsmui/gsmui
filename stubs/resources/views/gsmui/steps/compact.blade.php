@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
])

@php
$colors = [
    'blue' => ['active' => 'bg-blue-500 text-white', 'line' => 'bg-blue-500'],
    'green' => ['active' => 'bg-green-500 text-white', 'line' => 'bg-green-500'],
    'purple' => ['active' => 'bg-purple-500 text-white', 'line' => 'bg-purple-500'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['flex items-center gap-1']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
        @endphp
        
        <div class="flex items-center">
            <div class="flex items-center justify-center w-6 h-6 rounded text-xs font-semibold transition-all duration-300
                {{ $isActive ? $colorSet['active'] : ($isCompleted ? $colorSet['active'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                @if($isCompleted)
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                @else
                    {{ $stepNumber }}
                @endif
            </div>
            
            @if(!$loop->last)
                <div class="w-4 h-px mx-0.5 {{ $isCompleted ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }}"></div>
            @endif
        </div>
    @endforeach
</div>
