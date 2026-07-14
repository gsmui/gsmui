@blaze(fold: true)

@props([
    'variant' => null,
    'text' => null,
    'vertical' => false,
    'orientation' => null,
])

@php
$isVertical = $vertical || $orientation === 'vertical';

$lineClasses = Gsmui::classes()
    ->add($isVertical ? 'border-s' : 'border-t')
    ->add('border-zinc-200 dark:border-white/10')
    ->add($variant === 'subtle' ? 'opacity-40' : '')
    ;

$verticalClasses = Gsmui::classes()
    ->add('inline-block self-stretch')
    ->add($lineClasses)
    ;
@endphp

@if ($text && !$isVertical)
    <div {{ $attributes->class('flex items-center') }} data-gsmui-separator role="separator">
        <div class="flex-1 {{ (string) $lineClasses }}"></div>
        <span class="mx-3 text-xs font-medium uppercase tracking-wider text-zinc-400 dark:text-zinc-500">{{ $text }}</span>
        <div class="flex-1 {{ (string) $lineClasses }}"></div>
    </div>
@elseif ($isVertical)
    <div {{ $attributes->class($verticalClasses) }} data-gsmui-separator role="separator" aria-orientation="vertical"></div>
@else
    <div {{ $attributes->class($lineClasses) }} data-gsmui-separator role="separator"></div>
@endif
