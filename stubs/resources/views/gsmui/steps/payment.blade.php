@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
])

@php
$colors = [
    'blue' => ['bg' => 'bg-blue-600', 'text' => 'text-blue-600 dark:text-blue-400', 'border' => 'border-blue-600'],
    'green' => ['bg' => 'bg-green-600', 'text' => 'text-green-600 dark:text-green-400', 'border' => 'border-green-600'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
$icons = ['cart', 'credit-card', 'check-circle'];
@endphp

<div {{ $attributes->class(['bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden']) }}
     x-data="{ step: {{ $current }} }">
    
    {{-- Steps header --}}
    <div class="flex border-b border-zinc-200 dark:border-zinc-700">
        @foreach($steps as $index => $step)
            @php $stepNumber = $index + 1; @endphp
            <div class="flex-1 px-4 py-3 text-center border-b-2 transition-colors duration-300 cursor-pointer"
                 :class="step === {{ $stepNumber }} ? '{{ $colorSet['border'] }} {{ $colorSet['text'] }}' : 'border-transparent text-zinc-500'"
                 @click="step = {{ $stepNumber }}">
                <span class="text-sm font-medium">{{ $step['title'] ?? 'Step ' . $stepNumber }}</span>
            </div>
        @endforeach
    </div>
    
    {{-- Content --}}
    <div class="p-6 min-h-[250px]">
        @foreach($steps as $index => $step)
            <div x-show="step === {{ $index + 1 }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @if(isset($step['content']))
                    {{ $step['content'] }}
                @else
                    <div class="text-center py-8">
                        <div class="text-4xl mb-4">{{ ['🛒', '💳', '✅'][$index] ?? '📝' }}</div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $step['title'] ?? 'Step ' . ($index + 1) }}</h3>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    {{-- Footer --}}
    <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
        <button @click="step = Math.max(1, step - 1)" x-show="step > 1"
                class="px-4 py-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">
            ← Back
        </button>
        <div x-show="step <= 1"></div>
        <button @click="step++" x-show="step < {{ count($steps) }}"
                class="px-4 py-2 text-sm font-medium text-white {{ $colorSet['bg'] }} rounded-lg hover:opacity-90">
            Next →
        </button>
        <button x-show="step === {{ count($steps) }}"
                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
            Confirm Payment
        </button>
    </div>
</div>
