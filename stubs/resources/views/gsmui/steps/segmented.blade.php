@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'h-1.5',
    'md' => 'h-2.5',
    'lg' => 'h-4',
];

$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
];
$colorClass = $colors[$color] ?? 'bg-blue-500';
$heightClass = $sizes[$size] ?? 'h-2.5';

$total = count($steps);
$segmentWidth = 100 / $total;
@endphp

<div {{ $attributes->class(['select-none']) }}>
    {{-- Segmented track --}}
    <div class="flex {{ $heightClass }} gap-1 mb-4">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isCompleted = $stepNumber < $current;
                $isActive = $stepNumber === $current;
            @endphp
            
            <div class="flex-1 rounded-full overflow-hidden {{ $heightClass }} bg-zinc-200 dark:bg-zinc-700">
                <div class="h-full rounded-full transition-all duration-500 ease-out {{ $isCompleted || $isActive ? $colorClass : '' }}" 
                     style="width: {{ $isCompleted ? '100%' : ($isActive ? '50%' : '0%') }}"></div>
            </div>
        @endforeach
    </div>
    
    {{-- Step labels --}}
    <div class="flex justify-between">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp
            
            <div class="flex flex-col items-center" style="width: {{ $segmentWidth }}%;">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-semibold mb-2
                    {{ $isActive ? $colorClass . ' text-white' : ($isCompleted ? $colorClass . ' text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                    @if($isCompleted)
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
                
                <span class="text-xs text-center font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                    {{ $step['title'] ?? 'Step ' . $stepNumber }}
                </span>
            </div>
        @endforeach
    </div>
</div>
