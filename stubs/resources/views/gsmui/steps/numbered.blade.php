@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'size' => 'md',
])

@php
    $sizes = ['sm' => 'w-8 h-8 text-xs', 'md' => 'w-10 h-10 text-sm', 'lg' => 'w-12 h-12 text-base'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $colors = [
        'blue' => 'bg-blue-500 text-white shadow-blue-500/30',
        'green' => 'bg-green-500 text-white shadow-green-500/30',
        'purple' => 'bg-purple-500 text-white shadow-purple-500/30',
        'amber' => 'bg-amber-500 text-white shadow-amber-500/30',
    ];
@endphp

<div {{ $attributes->class(["select-none"]) }}>
    <div class="flex flex-col space-y-4">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp

            <div class="flex items-start gap-4">
                {{-- Number Circle --}}
                <div class="relative flex items-center justify-center {{ $sizeClass }} rounded-full font-bold shadow-lg transition-all duration-300 {{ $isActive ? $colors[$color] ?? $colors['blue'] : ($isCompleted ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                    @if($isCompleted)
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1 pt-1">
                    <h3 class="font-semibold {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </h3>
                    @if(isset($step['description']))
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $step['description'] }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
