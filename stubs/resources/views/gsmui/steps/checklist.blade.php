@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'showProgress' => true,
])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500',
        'purple' => 'bg-purple-500',
    ];
    $completedCount = $current - 1;
    $totalSteps = count($steps);
    $percentage = $totalSteps > 0 ? round(($completedCount / $totalSteps) * 100) : 0;
@endphp

<div {{ $attributes->class(["select-none"]) }}>
    @if($showProgress)
        <div class="mb-6">
            <div class="flex items-center justify-between text-sm mb-2">
                <span class="text-zinc-600 dark:text-zinc-400">{{ $completedCount }} of {{ $totalSteps }} completed</span>
                <span class="font-medium text-zinc-900 dark:text-white">{{ $percentage }}%</span>
            </div>
            <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                <div class="h-full {{ $colors[$color] }} rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
            </div>
        </div>
    @endif

    <div class="space-y-3">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isCompleted = $stepNumber <= $current - 1;
                $isActive = $stepNumber === $current;
            @endphp

            <div class="flex items-center gap-4 p-4 rounded-xl transition-all duration-300 {{ $isActive ? 'bg-blue-50 dark:bg-blue-900/20 ring-2 ring-blue-500/30' : ($isCompleted ? 'bg-green-50 dark:bg-green-900/20' : 'bg-zinc-50 dark:bg-zinc-800') }}">
                {{-- Checkbox --}}
                <div class="flex-shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all duration-300 {{ $isCompleted ? $colors[$color] . ' border-transparent' : ($isActive ? 'border-blue-500' : 'border-zinc-300 dark:border-zinc-600') }}">
                    @if($isCompleted)
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    @elseif($isActive)
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1">
                    <h4 class="text-sm font-medium {{ $isCompleted ? 'text-green-700 dark:text-green-400 line-through' : ($isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400') }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </h4>
                    @if(isset($step['description']))
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ $step['description'] }}</p>
                    @endif
                </div>

                {{-- Status --}}
                <div class="text-xs font-medium {{ $isCompleted ? 'text-green-600 dark:text-green-400' : ($isActive ? 'text-blue-600 dark:text-blue-400' : 'text-zinc-400') }}">
                    {{ $isCompleted ? 'Done' : ($isActive ? 'Current' : 'Pending') }}
                </div>
            </div>
        @endforeach
    </div>
</div>
