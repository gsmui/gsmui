@blaze(fold: true)

@aware([ 'placeholder' ])

@props([
    'placeholder' => null,
    'clearable' => null,
    'invalid' => false,
    'suffix' => null,
    'size' => null,
    'max' => 1,
])

@php
// Clearable is not supported on xs size...
if ($size === 'xs') $clearable = null;

$classes = Gsmui::classes()
    ->add('group/select-button cursor-default py-2')
    ->add('overflow-hidden') // Overflow hidden is here to prevent the button from growing when selected text is too long.
    ->add('flex items-center')
    ->add('shadow-xs')
    ->add('bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]')
    // Make the placeholder match the text color of standard input placeholders...
    ->add('disabled:shadow-none')
    ->add(match ($size) {
        default => 'h-10 text-base sm:text-sm rounded-lg px-3 block w-full',
        'sm' => 'h-8 text-sm rounded-md ps-3 pe-2 block w-full',
        'xs' => 'h-6 text-xs rounded-md ps-3 pe-2 block w-full',
    })
    ->add($invalid
        ? 'border border-red-500'
        : 'border border-zinc-200 border-b-zinc-300/80 dark:border-white/10'
    )
    ;
@endphp

<button type="button" {{ $attributes->class($classes) }} @if ($invalid) data-invalid @endif data-gsmui-group-target data-gsmui-select-button>
    <?php if ($slot->isNotEmpty()): ?>
        {{ $slot }}
    <?php else: ?>
        <gsmui:select.selected :$placeholder :$max :$suffix />
    <?php endif; ?>

    <?php if ($clearable): ?>
        <gsmui:button as="div"
            class="cursor-pointer ms-2 -me-2 [[data-gsmui-select-button]:has([data-gsmui-select-placeholder])_&]:hidden [[data-gsmui-select][disabled]:has([data-selected])_&]:hidden"
            variant="subtle"
            :size="$size === 'sm' ? 'xs' : 'sm'"
            square
            tabindex="-1"
            aria-label="{{ __('Clear selected') }}"
            x-on:click.prevent.stop="$el.closest('ui-select').clear()"
        >
            <gsmui:icon.x-mark variant="micro" />
        </gsmui:button>
    <?php endif; ?>

    <gsmui:icon.chevron-down variant="mini" class="ms-2 -me-1 text-zinc-400/75 [[data-gsmui-select-button]:hover_&]:text-zinc-800 [[disabled]_&]:text-zinc-200! dark:text-white/60 dark:[[data-gsmui-select-button]:hover_&]:text-white dark:[[disabled]_&]:text-white/40!" />
</button>
