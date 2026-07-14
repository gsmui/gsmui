@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
])

@php
    $colors = [
        'blue' => ['dot' => 'bg-blue-500', 'line' => 'bg-blue-500'],
        'green' => ['dot' => 'bg-green-500', 'line' => 'bg-green-500'],
        'purple' => ['dot' => 'bg-purple-500', 'line' => 'bg-purple-500'],
    ];
    $colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["select-none"]) }}>
    <div class="relative">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
                $isLast = $index === count($steps) - 1;
            @endphp

            <div class="relative flex items-start pb-8">
                {{-- Timeline Line --}}
                @if(!$isLast)
                    <div class="absolute left-5 top-10 w-0.5 h-full {{ $stepNumber < $current ? $colorSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300"></div>
                @endif

                {{-- Timeline Dot --}}
                <div class="relative flex items-center justify-center w-10 h-10 rounded-full {{ $isActive ? $colorSet['dot'] : ($isCompleted ? $colorSet['dot'] : 'bg-zinc-200 dark:bg-zinc-700') }} transition-colors duration-300 z-10">
                    @if($isCompleted)
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    @elseif($isActive)
                        <div class="w-3 h-3 bg-white rounded-full animate-pulse"></div>
                    @else
                        <div class="w-3 h-3 bg-zinc-400 rounded-full"></div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="ml-4 flex-1">
                    <div class="flex items-center gap-3">
                        <h3 class="text-base font-semibold {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400' }}">
                            {{ $step['title'] ?? 'Step ' . $stepNumber }}
                        </h3>
                        @if(isset($step['date']))
                            <span class="text-xs text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">{{ $step['date'] }}</span>
                        @endif
                    </div>
                    @if(isset($step['description']))
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $step['description'] }}</p>
                    @endif
                    @if(isset($step['content']))
                        <div class="mt-3">
                            {{ $step['content'] }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
