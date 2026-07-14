@blaze(fold: true)

@props([
    'variant' => null,
    'color' => null,
    'text' => null,
    'align' => 'center',
    'vertical' => false,
    'orientation' => null,
    'label' => null,
])

@php
$isVertical = $vertical || $orientation === 'vertical';

$colorClasses = match ($color) {
    'primary' => 'border-blue-500',
    'secondary' => 'border-violet-500',
    'accent' => 'border-amber-500',
    'success' => 'border-emerald-500',
    'warning' => 'border-yellow-500',
    'danger' => 'border-red-500',
    'info' => 'border-sky-500',
    'neutral' => 'border-zinc-500 dark:border-zinc-400',
    default => 'border-zinc-300 dark:border-zinc-600',
};

$textColor = match ($color) {
    'primary' => 'text-blue-600 dark:text-blue-400',
    'secondary' => 'text-violet-600 dark:text-violet-400',
    'accent' => 'text-amber-600 dark:text-amber-400',
    'success' => 'text-emerald-600 dark:text-emerald-400',
    'warning' => 'text-yellow-600 dark:text-yellow-400',
    'danger' => 'text-red-600 dark:text-red-400',
    'info' => 'text-sky-600 dark:text-sky-400',
    'neutral' => 'text-zinc-500 dark:text-zinc-400',
    default => 'text-zinc-400 dark:text-zinc-500',
};

$displayText = $label ?? $text;

if ($isVertical) {
    $classes = Gsmui::classes()
        ->add('inline-block self-stretch border-s')
        ->add($colorClasses)
        ->add($variant === 'subtle' ? 'opacity-40' : '')
        ;
} else {
    $classes = Gsmui::classes()
        ->add('flex items-center w-full')
        ;

    $lineClasses = Gsmui::classes()
        ->add('flex-1 border-t')
        ->add($colorClasses)
        ->add($variant === 'subtle' ? 'opacity-40' : '')
        ;

    $alignStart = $align === 'start';
    $alignEnd = $align === 'end';
}
@endphp

@if ($isVertical)
    <div {{ $attributes->class($classes) }} data-gsmui-divider role="separator" aria-orientation="vertical"></div>
@elseif ($displayText)
    <div {{ $attributes->class($classes) }} data-gsmui-divider role="separator">
        @if ($alignStart)
            <span class="text-xs font-medium uppercase tracking-wider whitespace-nowrap {{ $textColor }} me-3">{{ $displayText }}</span>
            <div class="{{ $lineClasses }}"></div>
        @elseif ($alignEnd)
            <div class="{{ $lineClasses }}"></div>
            <span class="text-xs font-medium uppercase tracking-wider whitespace-nowrap {{ $textColor }} ms-3">{{ $displayText }}</span>
        @else
            <div class="{{ $lineClasses }}"></div>
            <span class="text-xs font-medium uppercase tracking-wider whitespace-nowrap {{ $textColor }} mx-3">{{ $displayText }}</span>
            <div class="{{ $lineClasses }}"></div>
        @endif
    </div>
@else
    <div {{ $attributes->class($lineClasses) }} data-gsmui-divider role="separator"></div>
@endif
