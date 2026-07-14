@blaze(fold: true)

@props([
    'label' => null,
    'icon' => null,
    'collapsible' => false,
    'defaultOpen' => true,
    'compact' => false,
])

@php
$hasLabel = $label || ($slot?->label ?? false);
$renderedLabel = $slot?->label ?? $label;

$headerClasses = Gsmui::classes()
    ->add('flex items-center gap-2')
    ->add($compact ? 'px-2 py-1' : 'px-3 py-2')
    ;

$labelClasses = Gsmui::classes()
    ->add('text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500')
    ;

$iconClasses = Gsmui::classes()
    ->add('size-3 text-zinc-300 dark:text-zinc-600')
    ;

$itemsClasses = Gsmui::classes()
    ->add('flex flex-col')
    ->add($compact ? 'gap-0.5' : 'gap-1')
    ;
@endphp

<div {{ $attributes->class('flex flex-col') }} data-gsmui-sidebar-group>
    {{-- Group header --}}
    @if ($renderedLabel || $slot?->header ?? false)
        <div class="{{ $headerClasses }}">
            @if ($icon)
                <gsmui:icon :name="$icon" variant="mini" class="{{ $iconClasses }}" />
            @endif

            @if ($renderedLabel)
                <span class="{{ $labelClasses }}">{{ $renderedLabel }}</span>
            @endif

            {{ $slot->header ?? '' }}
        </div>
    @endif

    {{-- Group items --}}
    @if ($collapsible)
        <div
            x-data="{ open: {{ $defaultOpen ? 'true' : 'false' }} }"
            class="flex flex-col"
        >
            <div x-show="open" x-collapse class="{{ $itemsClasses }}">
                {{ $slot }}
            </div>
        </div>
    @else
        <div class="{{ $itemsClasses }}">
            {{ $slot }}
        </div>
    @endif
</div>
