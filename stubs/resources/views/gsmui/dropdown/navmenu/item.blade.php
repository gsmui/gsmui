@blaze(fold: true)

@props([
    'icon' => null,
    'iconVariant' => 'mini',
    'variant' => null,
    'disabled' => false,
    'href' => '#',
    'current' => false,
])

@php
$classes = Gsmui::classes()
    ->add('group flex w-full items-center gap-3 rounded-md px-2.5 py-2 text-sm transition-colors')
    ->add($disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer')
    ->add($current
        ? 'bg-zinc-100 dark:bg-white/10 text-zinc-900 dark:text-white font-medium'
        : (match ($variant) {
            'danger' => 'text-red-700 dark:text-red-400 ' . ($disabled ? '' : 'hover:bg-red-50 dark:hover:bg-red-900/20'),
            default => 'text-zinc-700 dark:text-zinc-300 ' . ($disabled ? '' : 'hover:bg-zinc-100 dark:hover:bg-white/10'),
        })
    )
    ;
@endphp

<a href="{{ $href }}" {{ $attributes->class($classes) }} role="menuitem" @if ($current) aria-current="page" @endif data-gsmui-navmenu-item>
    @if ($icon)
        <span class="flex items-center shrink-0 size-5">
            <gsmui:icon :name="$icon" :variant="$iconVariant" class="text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-600 dark:group-hover:text-zinc-300" />
        </span>
    @endif

    <span class="flex-1 truncate">{{ $slot }}</span>
</a>
