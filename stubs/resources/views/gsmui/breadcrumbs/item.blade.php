@blaze(fold: true)

@props([
    'href' => null,
    'current' => false,
    'disabled' => false,
    'icon' => null,
    'separator' => 'chevron-right',
])

@php
$classes = Gsmui::classes()
    ->add('inline-flex items-center gap-1.5')
    ->add($current ? 'text-zinc-900 dark:text-white font-medium' : 'text-zinc-500 dark:text-zinc-400')
    ->add($disabled ? 'opacity-50 cursor-not-allowed' : '')
    ;

$isCurrent = $current || (!$href && !$disabled);
$isFirst = $attributes->has('first');
@endphp

<li class="inline-flex items-center gap-1" @if ($isCurrent) aria-current="page" @endif data-gsmui-breadcrumb-item>
    @if (!$isFirst)
        <gsmui:icon :name="$separator" variant="micro" class="size-4 text-zinc-400 dark:text-zinc-500 shrink-0 mx-0.5" aria-hidden="true" />
    @endif

    @if ($href && !$isCurrent && !$disabled)
        <a href="{{ $href }}" {{ $attributes->except('first')->class($classes) }}>
            @if ($icon)
                <gsmui:icon :name="$icon" variant="mini" class="size-4 shrink-0" />
            @endif
            {{ $slot }}
        </a>
    @else
        <span {{ $attributes->except('first')->class($classes) }} @if ($disabled) aria-disabled="true" @endif>
            @if ($icon)
                <gsmui:icon :name="$icon" variant="mini" class="size-4 shrink-0" />
            @endif
            {{ $slot }}
        </span>
    @endif
</li>
