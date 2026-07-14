@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
])

@php
$colors = [
    'blue' => ['active' => 'bg-blue-600 text-white', 'line' => 'bg-blue-600', 'completed' => 'bg-green-500 text-white'],
    'green' => ['active' => 'bg-green-600 text-white', 'line' => 'bg-green-600', 'completed' => 'bg-green-500 text-white'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl p-6']) }}>
    <div class="flex items-center justify-between">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp
            
            <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300
                        {{ $isActive ? $colorSet['active'] . ' ring-4 ring-blue-500/20' : ($isCompleted ? $colorSet['completed'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                        @if($isCompleted)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @else
                            {{ $stepNumber }}
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-semibold uppercase tracking-wide {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                </div>
                
                @if(!$loop->last)
                    <div class="flex-1 mx-4 h-0.5 {{ $isCompleted ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300 mt-[-20px]"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>
