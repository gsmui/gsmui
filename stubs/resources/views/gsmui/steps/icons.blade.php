@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
])

@php
    $colors = [
        'blue' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-500', 'border' => 'border-blue-500'],
        'green' => ['bg' => 'bg-green-500', 'text' => 'text-green-500', 'border' => 'border-green-500'],
        'purple' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-500', 'border' => 'border-purple-500'],
    ];
    $colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["select-none"]) }}>
    <div class="flex flex-col md:flex-row md:items-start gap-4">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
            @endphp

            <div class="flex-1 relative">
                <div class="flex flex-col items-center text-center p-4 rounded-xl transition-all duration-300 {{ $isActive ? 'bg-zinc-50 dark:bg-zinc-800 shadow-lg' : '' }}">
                    {{-- Icon --}}
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-3 transition-all duration-300 {{ $isCompleted ? $colorSet['bg'] . ' text-white' : ($isActive ? 'bg-white dark:bg-zinc-700 shadow-lg ring-2 ' . $colorSet['border'] : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-400') }}">
                        @if($isCompleted)
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        @else
                            {{ $step['icon'] ?? ($stepNumber) }}
                        @endif
                    </div>
                    <h4 class="text-sm font-semibold {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400' }}">{{ $step['title'] ?? 'Step ' . $stepNumber }}</h4>
                    @if(isset($step['description']))
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ $step['description'] }}</p>
                    @endif
                </div>

                {{-- Connector --}}
                @if($index < count($steps) - 1)
                    <div class="hidden md:block absolute top-1/2 -right-2 w-4 h-0.5 {{ $isCompleted ? $colorSet['bg'] : 'bg-zinc-200 dark:bg-zinc-700' }}"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>
