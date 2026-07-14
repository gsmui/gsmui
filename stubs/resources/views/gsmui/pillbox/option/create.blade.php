@blaze(fold: true)

@props([
    'modal' => null,
])

@php
$classes = Gsmui::classes()
    ->add('group/option overflow-hidden data-hidden:hidden group flex items-center px-2 py-1.5 w-full focus:outline-hidden')
    ->add('rounded-md')
    ->add('text-start text-sm font-medium select-none')
    ->add('text-zinc-800 data-active:bg-zinc-100 [&[disabled]]:text-zinc-400 dark:text-white dark:data-active:bg-zinc-600 dark:[&[disabled]]:text-zinc-400')
    ;

if ($modal) {
    $attributes = $attributes->merge(['x-on:click' => "\$dispatch('modal-show', { name: '{$modal}' })"]);
}

if ($attributes->whereStartsWith('wire:click')->isNotEmpty()) {
    $attributes = $attributes->merge(['wire:loading.attr' => 'data-gsmui-loading']);
}
@endphp

<ui-option-create {{ $attributes->class($classes) }} action data-gsmui-option-create>
    <div class="w-6 shrink-0">
        <gsmui:icon variant="mini" icon="plus" />
    </div>

    <span>{{ $slot }}</span>

    <gsmui:icon.loading class="hidden [[data-gsmui-loading]>&]:block ms-auto text-zinc-400 [[data-gsmui-menu-item]:hover_&]:text-current" variant="micro" />
</ui-option-create>
