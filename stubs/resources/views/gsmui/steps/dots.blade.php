@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'w-2 h-2',
    'md' => 'w-3 h-3',
    'lg' => 'w-4 h-4',
];

$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
    'red' => 'bg-red-500',
    'amber' => 'bg-amber-500',
];
$colorClass = $colors[$color] ?? 'bg-blue-500';
$sizeClass = $sizes[$size] ?? 'w-3 h-3';
@endphp

<div {{ $attributes->class(['flex items-center gap-3']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
        @endphp
        
        <div class="flex items-center gap-3">
            <div class="relative group">
                <div 
                    class="{{ $sizeClass }} rounded-full transition-all duration-300 cursor-pointer
                    {{ $isActive ? $colorClass . ' scale-125' : ($isCompleted ? $colorClass : 'bg-zinc-300 dark:bg-zinc-600') }}"
                ></div>
                
                {{-- Tooltip --}}
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-zinc-900 dark:bg-zinc-700 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                    {{ $step['title'] ?? 'Step ' . $stepNumber }}
                </div>
            </div>
            
            @if(!$loop->last)
                <div class="w-8 h-0.5 {{ $isCompleted ? $colorClass : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300"></div>
            @endif
        </div>
    @endforeach
</div>
