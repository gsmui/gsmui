@props([
    'label' => 'New',
    'variant' => 'blue',
    'removable' => false,
    'size' => 'md',
])

@php
$variants = [
    'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    'green' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    'red' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
    'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
    'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400',
    'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400',
    'zinc' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400',
];
$variantClass = $variants[$variant] ?? $variants['blue'];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs gap-1',
    'md' => 'px-2.5 py-1 text-sm gap-1.5',
    'lg' => 'px-3 py-1.5 text-base gap-2',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<span {{ $attributes->class([
    'inline-flex items-center font-medium rounded-md',
    $variantClass,
    $sizeClass,
]) }}>
    {{ $label }}
    
    @if($removable)
        <button class="hover:bg-black/10 dark:hover:bg-white/10 rounded p-0.5 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</span>
