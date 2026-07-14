@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'px-3 py-1 text-xs',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$colors = [
    'blue' => ['active' => 'bg-blue-500 text-white', 'line' => 'bg-blue-500', 'inactive' => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500'],
    'green' => ['active' => 'bg-green-500 text-white', 'line' => 'bg-green-500', 'inactive' => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500'],
    'purple' => ['active' => 'bg-purple-500 text-white', 'line' => 'bg-purple-500', 'inactive' => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['flex items-center gap-2']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
        @endphp
        
        <div class="flex items-center">
            <div class="rounded-full transition-all duration-300 {{ $sizes[$size] }}
                {{ $isActive ? $colorSet['active'] . ' font-semibold shadow-lg' : ($isCompleted ? $colorSet['active'] : $colorSet['inactive']) }}">
                @if($isCompleted)
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                @endif
                {{ $step['title'] ?? 'Step ' . $stepNumber }}
            </div>
            
            @if(!$loop->last)
                <div class="w-8 h-0.5 mx-2 {{ $isCompleted ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300"></div>
            @endif
        </div>
    @endforeach
</div>
