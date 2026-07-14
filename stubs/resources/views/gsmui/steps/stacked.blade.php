@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'compact' => false,
])

@php
$colors = [
    'blue' => ['active' => 'border-blue-500 bg-blue-50 dark:bg-blue-500/10', 'badge' => 'bg-blue-500 text-white'],
    'green' => ['active' => 'border-green-500 bg-green-50 dark:bg-green-500/10', 'badge' => 'bg-green-500 text-white'],
    'purple' => ['active' => 'border-purple-500 bg-purple-50 dark:bg-purple-500/10', 'badge' => 'bg-purple-500 text-white'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['space-y-4']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
        @endphp
        
        <div class="border rounded-xl transition-all duration-300 {{ $isActive ? $colorSet['active'] . ' border-l-4' : ($isCompleted ? 'border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800' : 'border-zinc-200 dark:border-zinc-700') }}">
            <div class="p-4">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold {{ $isCompleted ? $colorSet['badge'] : ($isActive ? $colorSet['badge'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                        @if($isCompleted)
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @else
                            {{ $stepNumber }}
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-700 dark:text-zinc-300' }}">
                            {{ $step['title'] ?? 'Step ' . $stepNumber }}
                        </h3>
                        @if(isset($step['description']))
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                {{ $step['description'] }}
                            </p>
                        @endif
                    </div>
                    
                    @if($isActive)
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $colorSet['badge'] }}">
                            Current
                        </span>
                    @endif
                </div>
                
                @if($isActive && isset($step['content']))
                    <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        {{ $step['content'] }}
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
