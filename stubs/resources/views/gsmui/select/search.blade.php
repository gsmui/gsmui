@blaze

@props([
    'clearable' => true,
    'closable' => null,
    'icon' => null,
])

@php
// Clerable or closable, not both...
if ($closable !== null) $clearable = null;

$classes = Gsmui::classes()
    ->add('h-10 w-full flex items-center px-3 py-2')
    ->add('font-medium text-base sm:text-sm text-zinc-800 dark:text-white')
    ->add('ps-9') // Make room for magnifying glass icon...
    ->add('pe-9') // Make room for clear/clos button and loading indicator...
    ->add('outline-hidden')
    ->add('border-b border-zinc-200 dark:border-zinc-600')
    ->add('bg-white dark:bg-zinc-700')
    // The below reverts styles added by Tailwind Forms plugin
    ->add('border-t-0 border-s-0 border-e-0 focus:ring-0 focus:border-zinc-200 dark:focus:border-zinc-600')
    ->add('data-invalid:text-red-500 dark:data-invalid:text-red-400')
    ;

$name = $attributes->whereStartsWith('wire:model')->first();

$invalid ??= ($name && $errors->has($name));

$loading = ($wireModel = $attributes->wire('model')) && $wireModel->directive && $wireModel->hasModifier('live');

if ($loading) {
    $attributes = $attributes->merge(['wire:loading.attr' => 'data-gsmui-loading']);
}
@endphp

<div class="relative flex grow mx-[-5px] mt-[-5px] mb-[5px]" data-gsmui-select-search>
    <div class="absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400 ps-3.5 start-0">
        <?php if (is_string($icon)): ?>
            <gsmui:icon :$icon variant="micro" />
        <?php elseif ($icon): ?>
            {{ $icon }}
        <?php else: ?>
            <gsmui:icon.magnifying-glass variant="micro" />
        <?php endif; ?>
    </div>

    <input
        type="text"
        @if ($invalid) aria-invalid="true" data-invalid @endif
        {{ $attributes->class($classes)->merge(['placeholder' => __('Search...')]) }}
    />

    <?php if ($loading): ?>
        <div class="opacity-0 [[data-gsmui-select-search]:has([data-gsmui-loading])_&]:opacity-100 transition-opacity absolute top-0 bottom-0 flex items-center justify-center pe-2.5 end-0">
            <gsmui:icon.loading class="text-zinc-400 [[data-gsmui-menu-item]:hover_&]:text-current" variant="mini" />
        </div>
    <?php endif; ?>

    <?php if ($closable): ?>
        <div class="[[data-gsmui-select-search]:has([data-gsmui-loading])_&]:opacity-0 transition-opacity absolute top-0 bottom-0 flex items-center justify-center pe-1 end-0">
            <ui-close>
                <gsmui:button square variant="subtle" size="sm" aria-label="{{ __('Clear search input') }}">
                    <gsmui:icon.x-mark variant="micro" />
                </gsmui:button>
            </ui-close>
        </div>
    <?php elseif ($clearable): ?>
        <div class="[[data-gsmui-select-search]:has([data-gsmui-loading])_&]:opacity-0 transition-opacity absolute top-0 bottom-0 flex items-center justify-center pe-1 end-0 [[data-gsmui-select-search]:has(input:placeholder-shown)_&]:hidden">
            <gsmui:button square variant="subtle" size="sm" tabindex="-1" aria-label="{{ __('Clear command input') }}"
                x-data="fluxSelectSearchClearable"
                x-on:click="clear()"
            >
                <gsmui:icon.x-mark variant="micro" />
            </gsmui:button>
        </div>
    <?php endif; ?>
</div>
