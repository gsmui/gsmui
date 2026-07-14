@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'variant' => 'underline',
])

@php
$colors = [
    'blue' => ['active' => 'text-blue-600 dark:text-blue-400', 'border' => 'border-blue-600 dark:border-blue-400', 'bg' => 'bg-blue-100 dark:bg-blue-900/30'],
    'green' => ['active' => 'text-green-600 dark:text-green-400', 'border' => 'border-green-600 dark:border-green-400', 'bg' => 'bg-green-100 dark:bg-green-900/30'],
    'purple' => ['active' => 'text-purple-600 dark:text-purple-400', 'border' => 'border-purple-600 dark:border-purple-400', 'bg' => 'bg-purple-100 dark:bg-purple-900/30'],
];
$colorSet = $colors[$color] ?? $colors['blue'];

$variants = [
    'underline' => 'border-b-2',
    'pills' => 'rounded-full px-4 py-2',
    'boxed' => 'rounded-lg border',
];
$variantClass = $variants[$variant] ?? $variants['underline'];
@endphp

<div {{ $attributes->class(['select-none']) }} x-data="{ activeTab: {{ $current }} }">
    {{-- Tab list --}}
    <div class="flex {{ $variant === 'pills' ? 'gap-2' : '' }}">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
            @endphp
            
            <button 
                type="button"
                class="flex items-center gap-2 px-4 py-3 text-sm font-medium transition-all duration-200 {{ $variantClass }}
                {{ $isActive ? $colorSet['active'] . ' ' . $colorSet['border'] : 'text-zinc-500 dark:text-zinc-400 border-transparent hover:text-zinc-700 dark:hover:text-zinc-300' }}"
                @click="activeTab = {{ $stepNumber }}"
                :class="activeTab === {{ $stepNumber }} ? '{{ $colorSet['active'] }} {{ $variant === 'underline' ? $colorSet['border'] : ($variant === 'pills' ? $colorSet['bg'] : $colorSet['border'] . ' ' . $colorSet['bg']) }}' : ''"
            >
                <span class="flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center text-xs {{ $isActive ? 'bg-current text-white' : 'bg-zinc-300 dark:bg-zinc-600 text-zinc-600 dark:text-zinc-300' }}">
                    {{ $stepNumber }}
                </span>
                {{ $step['title'] ?? 'Step ' . $stepNumber }}
            </button>
        @endforeach
    </div>
    
    {{-- Tab panels --}}
    <div class="mt-4">
        @foreach($steps as $index => $step)
            @php $stepNumber = $index + 1; @endphp
            <div x-show="activeTab === {{ $stepNumber }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @if(isset($step['content']))
                    {{ $step['content'] }}
                @else
                    <div class="p-6 bg-zinc-50 dark:bg-zinc-800 rounded-xl">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $step['title'] ?? 'Step ' . $stepNumber }}</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 mt-2">{{ $step['description'] ?? 'Content for this step' }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
