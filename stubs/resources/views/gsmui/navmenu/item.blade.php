@blaze(fold: true)

@props([
    'href' => null,
    'active' => false,
    'icon' => null,
    'badge' => null,
])

@php
$classes = Gsmui::classes()
    ->add('flex items-center gap-2 px-3 py-2 text-sm rounded-md')
    ->add($active
        ? 'bg-blue-50 dark:bg-blue-950/30 text-blue-700 dark:text-blue-300 font-medium'
        : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
    )
    ;
@endphp

@if ($href)
    <a
        {{ $attributes->class($classes) }}
        href="{{ $href }}"
        data-gsmui-navmenu-item
        @if ($active) aria-current="page" @endif
    >
        @if ($icon)
            <gsmui:icon :$icon variant="mini" class="shrink-0" />
        @endif
        <span class="flex-1">{{ $slot }}</span>
        @if ($badge)
            <span class="ml-auto text-xs px-2 py-0.5 rounded-full bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300">
                {{ $badge }}
            </span>
        @endif
    </a>
@else
    <div
        {{ $attributes->class($classes) }}
        data-gsmui-navmenu-item
        role="link"
        tabindex="0"
    >
        @if ($icon)
            <gsmui:icon :$icon variant="mini" class="shrink-0" />
        @endif
        <span class="flex-1">{{ $slot }}</span>
        @if ($badge)
            <span class="ml-auto text-xs px-2 py-0.5 rounded-full bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300">
                {{ $badge }}
            </span>
        @endif
    </div>
@endif
