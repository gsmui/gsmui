@props([
    'steps' => [],
    'currentStep' => 1,
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'h-6 w-6 text-xs',
    'md' => 'h-8 w-8 text-sm',
    'lg' => 'h-10 w-10 text-base',
];

$gradients = [
    1 => 'from-blue-500 to-purple-500',
    2 => 'from-emerald-500 to-cyan-500',
    3 => 'from-amber-500 to-orange-500',
    4 => 'from-rose-500 to-pink-500',
    5 => 'from-violet-500 to-indigo-500',
];
@endphp

<div {{ $attributes->class(['flex items-center' => true]) }}>
    @foreach($steps as $index => $step)
        <div class="flex items-center">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center {{ $sizes[$size] }} rounded-full transition-all duration-300
                    {{ $index + 1 <= $currentStep ? 'bg-gradient-to-r text-white shadow-lg ' . ($gradients[($index % 5) + 1] ?? 'from-blue-500 to-purple-500') : 
                       'bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400' }}">
                    @if($index + 1 < $currentStep)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @else
                        {{ $index + 1 }}
                    @endif
                </div>
                <div class="mt-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    {{ $step['label'] ?? "Step " . ($index + 1) }}
                </div>
            </div>
            
            @if(!$loop->last)
                <div class="w-16 h-1 mx-4 rounded-full transition-colors duration-300
                    {{ $index + 1 < $currentStep ? 'bg-gradient-to-r from-emerald-400 to-cyan-400' : 'bg-zinc-200 dark:bg-zinc-700' }}"></div>
            @endif
        </div>
    @endforeach
</div>
