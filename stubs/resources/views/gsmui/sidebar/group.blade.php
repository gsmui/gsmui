@blaze(fold: true)

@props([
    'label' => null,
    'icon' => null,
    'collapsible' => true,
    'open' => false,
])

@php
$classes = Gsmui::classes()
    ->add('mb-1')
    ;
@endphp

<div
    {{ $attributes->class($classes) }}
    data-gsmui-sidebar-group
    x-data="{ open: @json($open) }"
>
    @if ($label)
        <button
            type="button"
            class="
                w-full flex items-center gap-2 px-3 py-2 text-sm font-medium
                text-zinc-700 dark:text-zinc-200
                hover:bg-zinc-100 dark:hover:bg-zinc-700
                rounded-md transition-colors
            "
            x-on:click="open = !open"
            x-show="$slots.label || $label"
            x-cloak
        >
            @if ($icon)
                <gsmui:icon :$icon variant="mini" class="shrink-0" />
            @endif
            <span class="flex-1 text-left" x-show="!open" x-cloak>{{ $label }}</span>
            <gsmui:icon.chevron-down variant="mini" class="shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" x-show="$slots.label || $label" x-cloak />
        </button>
    @endif

    <div x-show="open" x-cloak x-transition>
        {{ $slot }}
    </div>
</div>
