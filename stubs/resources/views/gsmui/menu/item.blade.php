@blaze(fold: true)

@props([
    'icon' => null,
    'disabled' => false,
    'danger' => false,
])

@php
$classes = Gsmui::classes()
    ->add('flex items-center gap-2 px-3 py-1.5 text-sm')
    ->add('cursor-pointer select-none')
    ->add($disabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-zinc-100 dark:hover:bg-zinc-700')
    ->add($danger ? 'text-red-600 dark:text-red-400' : 'text-zinc-700 dark:text-zinc-200')
    ;
@endphp

<div
    {{ $attributes->class($classes) }}
    role="menuitem"
    tabindex="{{ $disabled ? '-1' : '0' }}"
    @if ($disabled) aria-disabled="true" @endif
    x-on:click="!$el.disabled && $dispatch('menu:select', { value: '{{ $attributes->get('value') }}' })"
    x-on:keydown.enter="$el.click()"
    x-on:keydown.space.prevent="$el.click()"
>
    @if ($icon)
        <gsmui:icon :$icon variant="mini" class="shrink-0" />
    @endif
    <span class="flex-1">{{ $slot }}</span>
    @if ($attributes->has('checked'))
        <gsmui:icon.check variant="mini" class="shrink-0 text-blue-600 dark:text-blue-400" />
    @endif
</div>
