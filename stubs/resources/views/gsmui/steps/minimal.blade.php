@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
])

@php
    $colors = [
        'blue' => 'text-blue-500',
        'green' => 'text-green-500',
        'purple' => 'text-purple-500',
    ];
@endphp

<div {{ $attributes->class(["select-none"]) }}>
    <div class="flex items-center gap-2">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp

            <div class="flex items-center">
                <span class="text-sm font-medium {{ $isActive ? ($colors[$color] ?? 'text-blue-500') : ($isCompleted ? 'text-zinc-900 dark:text-white' : 'text-zinc-400') }} transition-colors">
                    {{ $step['title'] ?? 'Step ' . $stepNumber }}
                </span>
                @if($index < count($steps) - 1)
                    <svg class="w-4 h-4 mx-2 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                @endif
            </div>
        @endforeach
    </div>
</div>
