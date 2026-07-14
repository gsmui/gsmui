@props([
    'label' => 'Tag',
    'icon' => null,
    'variant' => 'default',
    'closable' => false,
    'size' => 'md',
])

@php
$variants = [
    'default' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
    'primary' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
    'success' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
    'warning' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
    'danger' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
];
$variantClass = $variants[$variant] ?? $variants['default'];

$sizes = [
    'sm' => 'h-6 px-2 text-xs gap-1',
    'md' => 'h-7 px-2.5 text-sm gap-1.5',
    'lg' => 'h-8 px-3 text-base gap-2',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<span {{ $attributes->class([
    'inline-flex items-center font-medium rounded-full',
    $variantClass,
    $sizeClass,
]) }}>
    @if($icon)
        <span class="flex-shrink-0">{!! $icon !!}</span>
    @endif
    
    {{ $label }}
    
    @if($closable)
        <button class="flex-shrink-0 hover:bg-black/10 dark:hover:bg-white/10 rounded-full p-0.5 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</span>
