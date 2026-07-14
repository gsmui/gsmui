@blaze(fold: true)

@props([
    'id' => null,
    'label' => __('Toggle sidebar'),
    'variant' => 'default',
    'size' => 'default',
    'active' => false,
    'animated' => true,
    'srOnly' => false,
])

@php
if (!$id) {
    throw new InvalidArgumentException('The [id] prop is required for gsmui:layouts.sidebar.toggle. It must match the sidebar\'s [id] prop.');
}

$sizeClasses = match ($size) {
    'xs' => 'h-7 w-7',
    'sm' => 'h-8 w-8',
    'lg' => 'h-11 w-11',
    default => 'h-9 w-9',
};

$variantClasses = match ($variant) {
    'solid' => 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 hover:bg-zinc-800 dark:hover:bg-zinc-100 shadow-sm',
    'primary' => 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm shadow-blue-500/20',
    'ghost' => 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800',
    'subtle' => 'text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-300',
    default => 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-700 dark:hover:text-zinc-200',
};

$barBase = 'absolute left-1/2 block h-px w-4 -translate-x-1/2 rounded-full transition-all duration-200 bg-current';

$topBar = $animated ? ($active ? 'top-1/2 -translate-y-1/2 rotate-45' : 'top-[9px]') : 'top-1/2 -translate-y-1/2';
$midBar = $animated ? ($active ? 'opacity-0 scale-x-0' : 'top-1/2 -translate-y-1/2') : 'top-1/2 -translate-y-1/2';
$botBar = $animated ? ($active ? 'top-1/2 -translate-y-1/2 -rotate-45' : 'top-[15px]') : 'top-1/2 -translate-y-1/2';
@endphp

<button
    type="button"
    onclick="window.dispatchEvent(new CustomEvent('toggle-sidebar-{{ $id }}'))"
    {{ $attributes->class([
        'relative inline-flex items-center justify-center rounded-lg transition-colors duration-150',
        $sizeClasses,
        $variantClasses,
    ]) }}
    aria-label="{{ $label }}"
    data-gsmui-sidebar-toggle
>
    {{-- Hamburger icon --}}
    <span class="relative inline-block size-4" aria-hidden="true">
        <span class="{{ $barBase }} {{ $topBar }}"></span>
        <span class="{{ $barBase }} {{ $midBar }}"></span>
        <span class="{{ $barBase }} {{ $botBar }}"></span>
    </span>

    {{-- Label text (shown when srOnly is false, after the icon) --}}
    @unless ($srOnly)
        <span class="ml-2 text-sm font-medium">{{ $label }}</span>
    @endunless
</button>
