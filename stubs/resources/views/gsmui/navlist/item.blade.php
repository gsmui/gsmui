@blaze(fold: true)

@props([
    'href' => '#',
    'current' => null,
    'icon' => null,
    'iconVariant' => 'mini',
    'badge' => null,
    'badgeColor' => 'zinc',
    'disabled' => false,
])

@php
$isCurrent = $current ?? request()->fullUrlIs($href) || request()->is(trim($href, '/'));

$classes = Gsmui::classes()
    ->add('flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors duration-150')
    ->add($isCurrent
        ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-white/10'
        : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-white/10'
    )
    ->add($disabled ? 'opacity-50 pointer-events-none' : '')
    ;
@endphp

<a href="{{ $href }}" {{ $attributes->class($classes) }} @if ($isCurrent) aria-current="page" @endif data-gsmui-navlist-item>
    @if ($icon)
        <gsmui:icon :name="$icon" :variant="$iconVariant" class="shrink-0 size-5 text-zinc-400 dark:text-zinc-500" />
    @endif

    <span class="flex-1 truncate">{{ $slot }}</span>

    @if ($badge !== null)
        <gsmui:badge :color="$badgeColor" size="sm">{{ $badge }}</gsmui:badge>
    @endif
</a>
