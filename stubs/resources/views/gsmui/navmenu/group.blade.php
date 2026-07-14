@blaze(fold: true)

@props([
    'label' => null,
    'icon' => null,
    'collapsible' => true,
    'defaultOpen' => false,
])

@php
$classes = Gsmui::classes()
    ->add('mb-1')
    ;
@endphp

<div
    {{ $attributes->class($classes) }}
    data-gsmui-navmenu-group
    x-data="{ open: @json($defaultOpen) }"
>
    <button
        type="button"
        x-show="{{ $label ? 'true' : 'false' }}"
        x-cloak
        class="
            w-full flex items-center gap-2 px-3 py-2 text-sm font-medium
            text-zinc-700 dark:text-zinc-200
            hover:bg-zinc-100 dark:hover:bg-zinc-700
            rounded-md transition-colors
        "
        x-on:click="open = !open"
    >
        @if ($icon)
            <gsmui:icon :$icon variant="mini" class="shrink-0" />
        @endif
        <span class="flex-1 text-left">{{ $label }}</span>
        <gsmui:icon.chevron-down variant="mini" class="shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" />
    </button>

    <div x-show="open" x-cloak x-transition class="ml-4 mt-1 flex flex-col gap-1">
        {{ $slot }}
    </div>
</div>
