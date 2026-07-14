@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'w-6 h-6 text-xs',
    'md' => 'w-8 h-8 text-sm',
    'lg' => 'w-10 h-10 text-base',
];

$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
    'red' => 'bg-red-500',
];
$colorClass = $colors[$color] ?? 'bg-blue-500';
@endphp

<div {{ $attributes->class(['relative']) }}>
    {{-- Center circle with current step info --}}
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
            <div class="text-center">
                <div class="text-xl font-bold text-zinc-900 dark:text-white">{{ $current }}</div>
                <div class="text-xs text-zinc-500">of {{ count($steps) }}</div>
            </div>
        </div>
    </div>
    
    {{-- Circular steps --}}
    <div class="relative w-40 h-40 mx-auto">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $angle = ($index / count($steps)) * 360 - 90;
                $x = 50 + 45 * cos($angle * M_PI / 180);
                $y = 50 + 45 * sin($angle * M_PI / 180);
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp
            
            <div class="absolute {{ $sizes[$size] }} rounded-full flex items-center justify-center transform -translate-x-1/2 -translate-y-1/2 transition-all duration-300"
                 style="left: {{ $x }}%; top: {{ $y }}%;"
                 @if($isActive) {{ 'style="left: ' . $x . '%; top: ' . $y . '%; transform: translate(-50%, -50%) scale(1.2);"' }}>
            @endif
                 class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold
                 {{ $isCompleted ? $colorClass . ' text-white' : ($isActive ? $colorClass . ' text-white scale-125' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                @if($isCompleted)
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                @else
                    {{ $stepNumber }}
                @endif
            </div>
        @endforeach
    </div>
    
    {{-- Step labels --}}
    <div class="mt-8 space-y-2">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
            @endphp
            <div class="flex items-center {{ $isActive ? 'text-zinc-900 dark:text-white font-medium' : 'text-zinc-500 dark:text-zinc-400' }}">
                <div class="w-2 h-2 rounded-full mr-3 {{ $stepNumber <= $current ? $colorClass : 'bg-zinc-300 dark:bg-zinc-600' }}"></div>
                {{ $step['title'] ?? 'Step ' . $stepNumber }}
            </div>
        @endforeach
    </div>
</div>
