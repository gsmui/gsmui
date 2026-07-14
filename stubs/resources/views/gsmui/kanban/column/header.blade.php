@blaze(fold: true)

@props([
    'heading' => null,
    'subheading' => null,
    'count' => null,
    'badge' => null,
])

@php
$classes = (string) Gsmui::classes()
    ->add('p-2 flex flex-col')
    ;

$badgeAttributes = Gsmui::attributesAfter('badge:', $attributes);
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-kanban-column-header>
    <div class="flex items-center justify-between min-h-8">
        <div class="px-3 flex items-center gap-1.5">
            {{ $slot }}

            @if ($heading)
                <gsmui:heading>{{ $heading }}</gsmui:heading>
            @endif

            @if ($count)
                <div class="text-sm text-zinc-500 dark:text-white/70">{{ $count }}</div>
            @endif

            @if ($badge)
                <gsmui:badge size="sm" :attributes="$badgeAttributes">{{ $badge }}</gsmui:badge>
            @endif
        </div>

        <div class="flex items-center gap-1">
            {{ $actions ?? '' }}
        </div>
    </div>

    @if ($subheading)
        <div class="px-3 flex items-center gap-1.5 mb-1">
            <gsmui:subheading>{{ $subheading }}</gsmui:subheading>
        </div>
    @endif
</div>