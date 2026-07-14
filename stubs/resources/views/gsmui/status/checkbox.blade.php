@props([
    'label' => 'Checkbox',
    'checked' => false,
    'color' => 'blue',
    'size' => 'md',
])

@php
$sizes = ['sm' => 'w-4 h-4', 'md' => 'w-5 h-5', 'lg' => 'w-6 h-6'];
$colors = [
    'blue' => 'bg-blue-500 border-blue-500',
    'green' => 'bg-green-500 border-green-500',
    'purple' => 'bg-purple-500 border-purple-500',
];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2 cursor-pointer']) }}>
    <div class="{{ $sizes[$size] ?? $sizes['md'] }} rounded {{ $checked ? $colors[$color] ?? $colors['blue'] : 'border-2 border-zinc-300 dark:border-zinc-600' }} flex items-center justify-center transition-colors">
        @if($checked)
            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
        @endif
    </div>
    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
</div>
