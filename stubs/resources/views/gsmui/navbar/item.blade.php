@blaze(fold: true)

@props([
    'href' => '#',
    'current' => null,
    'icon' => null,
    'iconVariant' => 'mini',
    'iconTrailing' => null,
    'badge' => null,
    'badgeColor' => 'zinc',
    'badgeVariant' => 'solid',
    'disabled' => false,
])

@php
$isCurrent = $current ?? request()->fullUrlIs($href) || request()->is(trim($href, '/'));

$classes = Gsmui::classes()
    ->add('inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium transition-colors duration-150 whitespace-nowrap')
    ->add($isCurrent
        ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-white/10'
        : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-white/10'
    )
    ->add($disabled ? 'opacity-50 pointer-events-none' : '')
    ;
@endphp

<a href="{{ $href }}" {{ $attributes->class($classes) }} @if ($isCurrent) aria-current="page" @endif data-gsmui-navbar-item>
    @if ($icon)
        <gsmui:icon :name="$icon" :variant="$iconVariant" class="shrink-0" />
    @endif

    <span class="truncate">{{ $slot }}</span>

    @if ($badge !== null)
        <gsmui:badge :color="$badgeColor" :variant="$badgeVariant" size="sm">{{ $badge }}</gsmui:badge>
    @endif

    @if ($iconTrailing)
        <gsmui:icon :name="$iconTrailing" variant="micro" class="shrink-0 text-zinc-400" />
    @endif
</a>
