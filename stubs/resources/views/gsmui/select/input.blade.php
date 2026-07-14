@blaze(fold: true)

@aware([ 'placeholder' ])

@props([
    'placeholder' => null,
    'clearable' => null,
    'size' => null,
])

@php
$loading = ($wireModel = $attributes->wire('model')) && $wireModel->directive && $wireModel->hasModifier('live');

if ($loading) {
    $attributes = $attributes->merge(['wire:loading.attr' => 'data-gsmui-loading']);
}
@endphp

<gsmui:input :$size :$placeholder :$attributes class:input="data-invalid:outline-red-500">
    <x-slot name="iconTrailing">
        <?php if ($clearable): ?>
            <gsmui:button as="div"
                class="cursor-pointer ms-2 -me-3 [[data-gsmui-input]:has(input:placeholder-shown)_&]:hidden [[data-gsmui-select]:has([disabled][data-selected])_&]:hidden"
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

        <gsmui:button size="sm" square variant="subtle" tabindex="-1" class="-me-1 [[disabled]_&]:pointer-events-none">
            <gsmui:icon.chevron-up-down variant="mini" class="text-zinc-400/75 [[data-gsmui-input]:hover_&]:text-zinc-800 [[disabled]_&]:text-zinc-200! dark:text-white/60 dark:[[data-gsmui-input]:hover_&]:text-white dark:[[disabled]_&]:text-white/40!" />
        </gsmui:button>
    </x-slot>
</gsmui:input>
