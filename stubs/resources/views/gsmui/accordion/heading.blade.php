@blaze(fold: true)

@aware([ 'disabled', 'variant' ])

@props([
    'disabled' => null,
    'variant' => null,
])

@php
$classes = Gsmui::classes()
    ->add('group/accordion-heading flex items-center w-full')
    ->add('text-start text-sm font-medium')
    ->add(match ($variant) {
        default => 'justify-between [&>svg]:ms-6',
        'reverse' => 'flex-row-reverse justify-end [&>svg]:me-2',
    })
    ->add($disabled
        ? 'text-zinc-400 dark:text-zinc-400 cursor-default'
        : 'text-zinc-800 dark:text-white cursor-pointer'
    )
    ;
@endphp

<button type="button" {{ $attributes->class($classes) }} @if ($disabled) disabled @endif data-gsmui-accordion-heading>
    <span class="flex-1">{{ $slot }}</span>

    <?php if ($variant === 'reverse'): ?>
        <gsmui:accordion.icon pointing="down" class="hidden group-data-open/accordion-heading:block text-zinc-800! dark:text-white!" />
        <gsmui:accordion.icon pointing="right" class="block group-data-open/accordion-heading:hidden" />
    <?php else: ?>
        <gsmui:accordion.icon pointing="up" class="hidden group-data-open/accordion-heading:block text-zinc-800! dark:text-white!" />
        <gsmui:accordion.icon pointing="down" class="block group-data-open/accordion-heading:hidden" />
    <?php endif; ?>
</button>
