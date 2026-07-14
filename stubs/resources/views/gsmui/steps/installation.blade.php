@props([
    'steps' => [],
    'current' => 1,
    'color' => 'cyan',
])

@php
$colors = [
    'cyan' => ['bg' => 'bg-cyan-500', 'text' => 'text-cyan-600 dark:text-cyan-400'],
    'blue' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-600 dark:text-blue-400'],
    'teal' => ['bg' => 'bg-teal-500', 'text' => 'text-teal-600 dark:text-teal-400'],
];
$colorSet = $colors[$color] ?? $colors['cyan'];
@endphp

<div {{ $attributes->class(['bg-zinc-900 dark:bg-zinc-950 rounded-xl overflow-hidden font-mono']) }}
     x-data="{ step: {{ $current }} }">
    
    {{-- Terminal header --}}
    <div class="flex items-center gap-2 px-4 py-2 bg-zinc-800 dark:bg-zinc-900">
        <div class="w-3 h-3 rounded-full bg-red-500"></div>
        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
        <div class="w-3 h-3 rounded-full bg-green-500"></div>
        <span class="ml-2 text-xs text-zinc-400">Installation Wizard</span>
    </div>
    
    {{-- Progress bar --}}
    <div class="px-4 py-3 border-b border-zinc-800">
        <div class="flex items-center gap-4">
            @foreach($steps as $index => $step)
                <div class="flex items-center gap-2 text-xs"
                     :class="step === {{ $index + 1 }} ? '{{ $colorSet['text'] }}' : (step > {{ $index + 1 }} ? 'text-green-400' : 'text-zinc-500')">
                    <span x-show="step > {{ $index + 1 }}">✓</span>
                    <span x-show="step <= {{ $index + 1 }}">{{ $index + 1 }}</span>
                    <span class="hidden sm:inline">{{ $step['title'] ?? 'Step' }}</span>
                </div>
                @if(!$loop->last)
                    <span class="text-zinc-600">→</span>
                @endif
            @endforeach
        </div>
    </div>
    
    {{-- Content --}}
    <div class="p-6 min-h-[200px] text-zinc-300">
        @foreach($steps as $index => $step)
            <div x-show="step === {{ $index + 1 }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @if(isset($step['content']))
                    {{ $step['content'] }}
                @else
                    <div class="space-y-3">
                        <div class="{{ $colorSet['text'] }} text-sm font-semibold">[{{ $step['title'] ?? 'Step ' . ($index + 1) }}]</div>
                        <div class="text-zinc-400 text-sm">{{ $step['description'] ?? 'Processing...' }}</div>
                        <div class="text-zinc-600 text-xs">$ npm install ...</div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    {{-- Navigation --}}
    <div class="px-6 py-4 border-t border-zinc-800 flex items-center justify-between">
        <button @click="step = Math.max(1, step - 1)" x-show="step > 1"
                class="text-xs text-zinc-500 hover:text-zinc-300 transition-colors">
            [← Previous]
        </button>
        <div x-show="step <= 1"></div>
        <button @click="step++" x-show="step < {{ count($steps) }}"
                class="text-xs {{ $colorSet['text'] }} hover:opacity-80 transition-opacity">
            [Next →]
        </button>
        <button x-show="step === {{ count($steps) }}"
                class="text-xs text-green-400 hover:opacity-80 transition-opacity">
            [Finish ✓]
        </button>
    </div>
</div>
