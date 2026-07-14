@props([
    'steps' => [],
    'current' => 1,
    'color' => 'indigo',
    'showSkip' => true,
    'skipLabel' => 'Skip',
    'nextLabel' => 'Next',
    'finishLabel' => 'Get Started',
])

@php
$colors = [
    'indigo' => ['bg' => 'bg-indigo-500', 'ring' => 'ring-indigo-500/30'],
    'blue' => ['bg' => 'bg-blue-500', 'ring' => 'ring-blue-500/30'],
    'violet' => ['bg' => 'bg-violet-500', 'ring' => 'ring-violet-500/30'],
];
$colorSet = $colors[$color] ?? $colors['indigo'];
$totalSteps = count($steps);
@endphp

<div {{ $attributes->class(['bg-white dark:bg-zinc-800 rounded-3xl shadow-xl overflow-hidden max-w-lg mx-auto']) }}
     x-data="{ step: {{ $current }}, total: {{ $totalSteps }} }">
    
    {{-- Dot indicators --}}
    <div class="flex items-center justify-center gap-2 pt-6">
        @foreach($steps as $index => $step)
            <div class="w-2 h-2 rounded-full transition-all duration-300"
                 :class="step === {{ $index + 1 }} ? '{{ $colorSet['bg'] }} w-6' : (step > {{ $index + 1 }} ? '{{ $colorSet['bg'] }}' : 'bg-zinc-300 dark:bg-zinc-600')"></div>
        @endforeach
    </div>
    
    {{-- Content --}}
    <div class="p-8 text-center min-h-[350px] flex flex-col items-center justify-center">
        @foreach($steps as $index => $step)
            <div x-show="step === {{ $index + 1 }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                @if(isset($step['icon']))
                    <div class="text-6xl mb-6">{{ $step['icon'] }}</div>
                @endif
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-3">{{ $step['title'] ?? 'Welcome' }}</h2>
                <p class="text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto">{{ $step['description'] ?? 'Let\'s get you started.' }}</p>
            </div>
        @endforeach
    </div>
    
    {{-- Navigation --}}
    <div class="px-8 pb-8 flex items-center justify-between">
        <button @click="step = Math.max(1, step - 1)" x-show="step > 1"
                class="text-sm text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors">
            Back
        </button>
        <div x-show="step <= 1"></div>
        
        <div class="flex items-center gap-3">
            @if($showSkip)
                <button x-show="step < total" class="text-sm text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors">
                    {{ $skipLabel }}
                </button>
            @endif
            <button @click="step = Math.min(total, step + 1)" x-show="step < total"
                    class="px-6 py-2.5 text-sm font-semibold text-white {{ $colorSet['bg'] }} rounded-full hover:opacity-90 transition-opacity">
                {{ $nextLabel }}
            </button>
            <button x-show="step === total"
                    class="px-6 py-2.5 text-sm font-semibold text-white {{ $colorSet['bg'] }} rounded-full hover:opacity-90 transition-opacity">
                {{ $finishLabel }}
            </button>
        </div>
    </div>
</div>
