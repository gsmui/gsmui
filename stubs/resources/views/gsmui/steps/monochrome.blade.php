@props([
    'steps' => [],
    'current' => 1,
    'shade' => 'zinc',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'w-8 h-8 text-xs',
    'md' => 'w-10 h-10 text-sm',
    'lg' => 'w-12 h-12 text-base',
];

$shades = [
    'zinc' => ['active' => 'bg-zinc-800 dark:bg-zinc-200 text-white dark:text-zinc-900', 'line' => 'bg-zinc-800 dark:bg-zinc-200'],
    'slate' => ['active' => 'bg-slate-800 dark:bg-slate-200 text-white dark:text-slate-900', 'line' => 'bg-slate-800 dark:bg-slate-200'],
    'gray' => ['active' => 'bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-900', 'line' => 'bg-gray-800 dark:bg-gray-200'],
    'neutral' => ['active' => 'bg-neutral-800 dark:bg-neutral-200 text-white dark:text-neutral-900', 'line' => 'bg-neutral-800 dark:bg-neutral-200'],
    'stone' => ['active' => 'bg-stone-800 dark:bg-stone-200 text-white dark:text-stone-900', 'line' => 'bg-stone-800 dark:bg-stone-200'],
];
$shadeSet = $shades[$shade] ?? $shades['zinc'];
@endphp

<div {{ $attributes->class(['flex items-center']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
        @endphp
        
        <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center {{ $sizes[$size] }} rounded-full transition-all duration-300
                    {{ $isActive || $isCompleted ? $shadeSet['active'] : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                    @if($isCompleted)
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
                
                <div class="mt-2 text-center">
                    <span class="text-sm font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                </div>
            </div>
            
            @if(!$loop->last)
                <div class="flex-1 mx-4 h-0.5 rounded-full {{ $isCompleted ? $shadeSet['line'] : 'bg-zinc-200 dark:bg-zinc-700' }} transition-colors duration-300"></div>
            @endif
        </div>
    @endforeach
</div>
