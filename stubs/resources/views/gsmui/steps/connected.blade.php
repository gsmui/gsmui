@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'orientation' => 'horizontal',
])

@php
    $colors = [
        'blue' => ['dot' => 'bg-blue-500', 'line' => 'bg-blue-500', 'text' => 'text-blue-500'],
        'green' => ['dot' => 'bg-green-500', 'line' => 'bg-green-500', 'text' => 'text-green-500'],
        'purple' => ['dot' => 'bg-purple-500', 'line' => 'bg-purple-500', 'text' => 'text-purple-500'],
    ];
    $colorSet = $colors[$color] ?? $colors['blue'];
    $isHorizontal = $orientation === 'horizontal';
@endphp

<div {{ $attributes->class(["select-none"]) }}>
    <div class="{{ $isHorizontal ? 'flex items-center' : 'flex flex-col' }}">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
                $isLast = $index === count($steps) - 1;
            @endphp

            {{-- Step Item --}}
            <div class="{{ $isHorizontal ? 'flex items-center' : 'flex items-start gap-4 pb-8' }} {{ !$isLast && $isHorizontal ? 'flex-1' : '' }}">
                {{-- Dot --}}
                <div class="relative flex-shrink-0">
                    <div class="w-4 h-4 rounded-full transition-all duration-300 {{ $isActive ? $colorSet['dot'] . ' ring-4 ring-opacity-30' : ($isCompleted ? $colorSet['dot'] : 'bg-zinc-300 dark:bg-zinc-600') }}"
                        style="{{ $isActive ? 'ring-color: currentColor;' : '' }}">
                    </div>
                </div>

                {{-- Content --}}
                <div class="{{ $isHorizontal ? 'ml-2' : 'flex-1' }}">
                    <span class="text-sm font-medium {{ $isActive ? $colorSet['text'] : ($isCompleted ? 'text-zinc-900 dark:text-white' : 'text-zinc-400') }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                    @if(isset($step['description']) && $isHorizontal)
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $step['description'] }}</p>
                    @endif
                </div>

                {{-- Line --}}
                @if(!$isLast && $isHorizontal)
                    <div class="flex-1 mx-3 h-px {{ $isCompleted ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>
