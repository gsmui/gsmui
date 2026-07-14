@props([
    'steps' => [],
    'current' => 1,
    'color' => 'violet',
])

@php
$colors = [
    'violet' => ['bg' => 'bg-violet-500', 'text' => 'text-violet-600 dark:text-violet-400'],
    'blue' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-600 dark:text-blue-400'],
    'purple' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-600 dark:text-purple-400'],
];
$colorSet = $colors[$color] ?? $colors['violet'];
@endphp

<div {{ $attributes->class(['bg-zinc-50 dark:bg-zinc-800/50 rounded-xl p-6']) }}
     x-data="{ step: {{ $current }} }">
    
    {{-- Pipeline visualization --}}
    <div class="flex items-center gap-2 mb-6">
        @foreach($steps as $index => $step)
            <div class="flex items-center">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center text-xs font-bold transition-all duration-300
                        {{ step === ($index + 1) ? $colorSet['bg'] . ' text-white scale-110 shadow-lg' : (step > ($index + 1) ? 'bg-green-500 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                        @if(step > ($index + 1))
                            ✓
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    <span class="mt-1 text-[10px] font-medium text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                        {{ $step['title'] ?? 'Stage' }}
                    </span>
                </div>
                
                @if(!$loop->last)
                    <div class="w-8 h-0.5 mx-1 {{ step > ($index + 1) ? 'bg-green-500' : 'bg-zinc-300 dark:bg-zinc-600' }} transition-colors duration-300"></div>
                @endif
            </div>
        @endforeach
    </div>
    
    {{-- Content --}}
    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4 min-h-[150px]">
        @foreach($steps as $index => $step)
            <div x-show="step === {{ $index + 1 }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @if(isset($step['content']))
                    {{ $step['content'] }}
                @else
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                        <div class="font-semibold text-zinc-900 dark:text-white mb-1">{{ $step['title'] ?? 'Stage ' . ($index + 1) }}</div>
                        <div>{{ $step['description'] ?? 'Pipeline stage in progress...' }}</div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    {{-- Controls --}}
    <div class="flex items-center justify-between mt-4">
        <button @click="step = Math.max(1, step - 1)" x-show="step > 1"
                class="text-sm text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
            ← Previous Stage
        </button>
        <div x-show="step <= 1"></div>
        <button @click="step++" x-show="step < {{ count($steps) }}"
                class="px-4 py-1.5 text-sm font-medium text-white {{ $colorSet['bg'] }} rounded-lg hover:opacity-90">
            Next Stage →
        </button>
        <button x-show="step === {{ count($steps) }}"
                class="px-4 py-1.5 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600">
            Deploy ✓
        </button>
    </div>
</div>
