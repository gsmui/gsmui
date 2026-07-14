@props([
    'steps' => [],
    'current' => 1,
    'color' => 'emerald',
])

@php
$colors = [
    'emerald' => ['bg' => 'bg-emerald-500', 'light' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-600 dark:text-emerald-400'],
    'blue' => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-600 dark:text-blue-400'],
];
$colorSet = $colors[$color] ?? $colors['emerald'];
$totalSteps = count($steps);
@endphp

<div {{ $attributes->class(['max-w-md mx-auto']) }}
     x-data="{ step: {{ $current }}, total: {{ $totalSteps }} }">
    
    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $colorSet['light'] }} {{ $colorSet['text'] }} text-sm font-medium mb-4">
            Step <span x-text="step"></span> of <span x-text="total"></span>
        </div>
        <div class="h-1 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
            <div class="h-full {{ $colorSet['bg'] }} transition-all duration-500" :style="`width: ${(step / total) * 100}%`"></div>
        </div>
    </div>
    
    {{-- Content --}}
    <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-lg p-6 min-h-[300px]">
        @foreach($steps as $index => $stepItem)
            <div x-show="step === {{ $index + 1 }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">{{ $stepItem['title'] ?? 'Step ' . ($index + 1) }}</h3>
                <p class="text-zinc-500 dark:text-zinc-400 mb-6">{{ $stepItem['description'] ?? 'Fill in the details below.' }}</p>
                
                @if(isset($stepItem['content']))
                    {{ $stepItem['content'] }}
                @endif
            </div>
        @endforeach
    </div>
    
    {{-- Buttons --}}
    <div class="flex items-center justify-between mt-6">
        <button @click="step = Math.max(1, step - 1)" x-show="step > 1"
                class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white transition-colors">
            ← Back
        </button>
        <div x-show="step <= 1"></div>
        <button @click="step = Math.min(total, step + 1)" x-show="step < total"
                class="px-6 py-2 text-sm font-semibold text-white {{ $colorSet['bg'] }} rounded-lg hover:opacity-90 transition-opacity">
            Continue →
        </button>
        <button x-show="step === total"
                class="px-6 py-2 text-sm font-semibold text-white bg-green-500 rounded-lg hover:bg-green-600 transition-colors">
            Create Account
        </button>
    </div>
</div>
