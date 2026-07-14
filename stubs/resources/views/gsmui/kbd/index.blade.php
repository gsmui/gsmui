@blaze(fold: true)

@props([
    'size' => null,
    'color' => null,
    'variant' => null,
    'ghost' => false,
    'wide' => false,
])

@php
// Base classes that apply regardless of variant
$baseClasses = 'inline-flex items-center justify-center font-mono font-medium leading-none select-none';

// Size-specific classes (first match only, no duplicates)
$sizeClasses = match ($size) {
    'xs' => 'h-5 min-w-5 px-1 text-[9px] rounded-[3px]',
    'sm' => 'h-6 min-w-6 px-1.5 text-xs rounded-[4px]',
    'lg' => 'h-10 min-w-10 px-3 text-sm rounded-lg',
    'xl' => 'h-12 min-w-12 px-4 text-base rounded-xl',
    default => 'h-7 min-w-7 px-2 text-xs rounded-md',
};

// Color classes
$colorClasses = match ($color) {
    'primary' => 'text-blue-600 dark:text-blue-400 border-blue-300 dark:border-blue-700',
    'success' => 'text-green-600 dark:text-green-400 border-green-300 dark:border-green-700',
    'danger' => 'text-red-600 dark:text-red-400 border-red-300 dark:border-red-700',
    'warning' => 'text-amber-600 dark:text-amber-400 border-amber-300 dark:border-amber-700',
    default => 'text-zinc-700 dark:text-zinc-300 border-zinc-300 dark:border-zinc-600',
};

// Variant classes (single consolidated match)
$variantClasses = match ($variant) {
    'outlined' => 'border-2 bg-transparent',
    'ghost' => 'bg-transparent border-0 shadow-none',
    default => 'border bg-white dark:bg-zinc-800',
};

// Shadow "3D key press" effect — only for non-ghost variants
$shadowClasses = '';
if (!$ghost && $variant !== 'ghost') {
    // Non-ghost keys get a bottom-shadow that creates a 3D key appearance
    $shadowOffset = match ($size) {
        'lg' => '0_3px_0_0',
        'xl' => '0_4px_0_0',
        default => '0_2px_0_0',
    };
    $translateY = match ($size) {
        'lg' => 'translate-y-0.5',
        'xl' => 'translate-y-1',
        default => 'translate-y-px',
    };
    $shadowClasses = "shadow-[{$shadowOffset}] shadow-zinc-300 dark:shadow-zinc-700 active:shadow-[0_1px_0_0] active:{$translateY}";
}

// Wide key override
$wideClasses = $wide ? 'min-w-[2.5em] px-3' : '';

$classes = Gsmui::classes()
    ->add($baseClasses)
    ->add($sizeClasses)
    ->add($colorClasses)
    ->add($variantClasses)
    ->add($shadowClasses)
    ->add($wideClasses)
    ;
@endphp

<kbd {{ $attributes->class($classes) }} data-gsmui-kbd>{{ $slot }}</kbd>
