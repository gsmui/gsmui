@blaze(fold: true)

@props([
    'icon' => null,
    'iconTrailing' => null,
    'iconVariant' => 'mini',
    'kbd' => null,
    'suffix' => null,
    'variant' => null,
    'disabled' => false,
    'keepOpen' => false,
    'href' => null,
])

@php
$tag = $href ? 'a' : 'button';

$classes = Gsmui::classes()
    ->add('group flex w-full items-center gap-3 rounded-md px-2.5 py-2 text-sm transition-colors')
    ->add($disabled
        ? 'opacity-50 cursor-not-allowed'
        : 'cursor-pointer'
    )
    ->add(match ($variant) {
        'danger' => 'text-red-700 dark:text-red-400 ' . ($disabled ? '' : 'hover:bg-red-50 dark:hover:bg-red-900/20'),
        default => 'text-zinc-700 dark:text-zinc-300 ' . ($disabled ? '' : 'hover:bg-zinc-100 dark:hover:bg-white/10'),
    })
    ;
@endphp

<{{ $tag }}
    @if ($tag === 'button') type="button" @if ($disabled) disabled @endif
    @elseif ($tag === 'a') href="{{ $href }}"
    @endif
    {{ $attributes->class($classes) }}
    role="menuitem"
    @if ($keepOpen) x-on:click.stop @endif
    data-gsmui-menu-item
>
    @if ($icon)
        <span class="flex items-center shrink-0 size-5">
            <gsmui:icon :name="$icon" :variant="$iconVariant" class="text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-600 dark:group-hover:text-zinc-300" />
        </span>
    @endif

    <span class="flex-1 truncate text-start">{{ $slot }}</span>

    @if ($suffix)
        <span class="text-xs text-zinc-400 dark:text-zinc-500">{{ $suffix }}</span>
    @endif

    @if ($kbd)
        <kbd class="hidden sm:inline-flex items-center rounded-md border border-zinc-200 dark:border-white/10 px-1.5 py-0.5 text-xs text-zinc-400 dark:text-zinc-500">{{ $kbd }}</kbd>
    @endif

    @if ($iconTrailing)
        <gsmui:icon :name="$iconTrailing" :variant="$iconVariant" class="size-4 text-zinc-400" />
    @endif
</{{ $tag }}>
