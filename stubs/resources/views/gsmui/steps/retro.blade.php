@props([
    'steps' => [],
    'current' => 1,
    'color' => 'amber',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'w-8 h-8 text-xs',
    'md' => 'w-10 h-10 text-sm',
    'lg' => 'w-12 h-12 text-base',
];

$colors = [
    'amber' => ['active' => 'bg-amber-600 text-amber-50 border-2 border-amber-800', 'line' => 'bg-amber-600'],
    'brown' => ['active' => 'bg-amber-800 text-amber-100 border-2 border-amber-900', 'line' => 'bg-amber-800'],
    'sepia' => ['active' => 'bg-yellow-700 text-yellow-100 border-2 border-yellow-800', 'line' => 'bg-yellow-700'],
];
$colorSet = $colors[$color] ?? $colors['amber'];
@endphp

<div {{ $attributes->class(['flex items-center', 'font-serif']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
        @endphp
        
        <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center {{ $sizes[$size] }} rounded-sm transition-all duration-300
                    {{ $isActive ? $colorSet['active'] . ' font-bold shadow-lg' : ($isCompleted ? $colorSet['active'] : 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-200 border-2 border-amber-300 dark:border-amber-700') }}">
                    @if($isCompleted)
                        <span class="text-lg">✓</span>
                    @else
                        <span class="text-lg">{{ $stepNumber }}</span>
                    @endif
                </div>
                
                <div class="mt-2 text-center">
                    <span class="text-sm font-medium italic {{ $isActive ? 'text-amber-900 dark:text-amber-100' : 'text-amber-700 dark:text-amber-300' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                </div>
            </div>
            
            @if(!$loop->last)
                <div class="flex-1 mx-4 h-0.5 {{ $isCompleted ? $colorSet['line'] : 'bg-amber-300 dark:bg-amber-700' }} transition-colors duration-300"></div>
            @endif
        </div>
    @endforeach
</div>
