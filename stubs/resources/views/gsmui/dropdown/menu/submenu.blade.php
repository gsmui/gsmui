@blaze(fold: true)

@props([
    'heading' => null,
    'icon' => null,
    'iconTrailing' => 'chevron-right',
    'iconVariant' => 'mini',
    'keepOpen' => false,
])

<div
    {{ $attributes->class('relative group/sub') }}
    @if ($keepOpen) x-on:click.stop @endif
    data-gsmui-menu-submenu
>
    <button type="button" class="group flex w-full items-center gap-3 rounded-md px-2.5 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-white/10 cursor-pointer transition-colors" data-gsmui-menu-item>
        @if ($icon)
            <gsmui:icon :name="$icon" :variant="$iconVariant" class="size-5 text-zinc-400" />
        @endif

        <span class="flex-1 truncate text-start">{{ $heading }}</span>

        <gsmui:icon :name="$iconTrailing" variant="mini" class="size-4 text-zinc-400" />
    </button>

    <div class="absolute left-full top-0 ml-1 min-w-48 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-700 p-1 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-150" data-gsmui-submenu-content>
        {{ $slot }}
    </div>
</div>
