@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'compact' => false,
])

@php
    $colors = [
        'blue' => ['active' => 'bg-blue-500 text-white', 'line' => 'bg-blue-500'],
        'green' => ['active' => 'bg-green-500 text-white', 'line' => 'bg-green-500'],
        'purple' => ['active' => 'bg-purple-500 text-white', 'line' => 'bg-purple-500'],
    ];
    $colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["select-none"]) }}>
    <div class="space-y-0">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
                $isLast = $index === count($steps) - 1;
            @endphp

            <div class="relative flex items-start {{ !$isLast ? 'pb-8' : '' }}">
                {{-- Vertical Line --}}
                @if(!$isLast)
                    <div class="absolute left-5 top-10 w-0.5 h-full {{ $stepNumber < $current ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300"></div>
                @endif

                {{-- Step Circle --}}
                <div class="relative flex items-center justify-center w-10 h-10 rounded-full {{ $isActive ? $colorSet['active'] : ($isCompleted ? $colorSet['active'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }} transition-colors duration-300">
                    @if($isCompleted)
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>

                {{-- Content --}}
                <div class="ml-4 flex-1">
                    <div class="flex items-center">
                        <h3 class="text-sm font-semibold {{ $isActive ? 'text-zinc-900 dark:text-white' : ($isCompleted ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400') }}">
                            {{ $step['title'] ?? 'Step ' . $stepNumber }}
                        </h3>
                        @if(isset($step['badge']))
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $colorSet['active'] }}">{{ $step['badge'] }}</span>
                        @endif
                    </div>
                    @if(isset($step['description']))
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $step['description'] }}</p>
                    @endif
                    @if(isset($step['content']))
                        <div class="mt-4 p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            {{ $step['content'] }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
