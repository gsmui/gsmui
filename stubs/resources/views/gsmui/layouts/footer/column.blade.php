@blaze(fold: true)

@props([
    'title' => null,
    'icon' => null,
    'compact' => false,
])

@php
$titleClasses = Gsmui::classes()
    ->add('text-sm font-semibold tracking-tight')
    ->add($compact ? 'mb-2' : 'mb-3')
    ->add('text-zinc-900 dark:text-white')
    ;

$listClasses = 'flex flex-col';
@endphp

<div {{ $attributes->class('flex flex-col') }} data-gsmui-footer-column>
    {{-- Title --}}
    @if ($icon || $title)
        <div class="{{ $titleClasses }}">
            @if ($icon)
                <gsmui:icon :name="$icon" variant="mini" class="size-3.5 shrink-0 inline-block align-text-bottom me-1.5 text-zinc-400 dark:text-zinc-500" />
            @endif
            {{ $title ?? $slot?->title ?? '' }}
        </div>
    @endif

    {{-- Links --}}
    @if ($slot?->links ?? false)
        <div class="{{ $listClasses }}">
            {{ $slot->links }}
        </div>
    @else
        <div class="{{ $listClasses }}">
            {{ $slot }}
        </div>
    @endif
</div>
