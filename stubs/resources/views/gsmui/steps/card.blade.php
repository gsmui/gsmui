@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'interactive' => false,
])

@php
    $colors = [
        'blue' => ['border' => 'border-blue-500', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-600 dark:text-blue-400'],
        'green' => ['border' => 'border-green-500', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'text' => 'text-green-600 dark:text-green-400'],
        'purple' => ['border' => 'border-purple-500', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600 dark:text-purple-400'],
    ];
    $colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["select-none"]) }}
    x-data="{ current: {{ $current }} }"
>
    <div class="grid grid-cols-1 md:grid-cols-{{ count($steps) }} gap-4">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp

            <div 
                class="relative p-6 rounded-2xl border-2 transition-all duration-300 {{ $isActive ? $colorSet['border'] . ' ' . $colorSet['bg'] . ' shadow-lg' : ($isCompleted ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800') }} {{ $interactive ? 'cursor-pointer hover:shadow-lg' : '' }}"
                @if($interactive) @click="current = {{ $stepNumber }}" @endif
            >
                {{-- Step Number Badge --}}
                <div class="absolute -top-3 -left-3 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $isActive ? $colorSet['bg'] . ' text-white' : ($isCompleted ? 'bg-green-500 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }} shadow-lg">
                    @if($isCompleted)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>

                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-2">{{ $step['title'] ?? 'Step ' . $stepNumber }}</h3>
                @if(isset($step['description']))
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $step['description'] }}</p>
                @endif
                @if(isset($step['icon']))
                    <div class="text-3xl mt-4">{{ $step['icon'] }}</div>
                @endif
            </div>
        @endforeach
    </div>
</div>
