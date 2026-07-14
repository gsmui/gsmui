@blaze(fold: true)

@props([
    'type' => 'static',
    'position' => 'left',
    'width' => 'md',
    'collapsible' => false,
    'open' => false,
])

@php
$widthMap = [
    'xs' => 'w-48',
    'sm' => 'w-56',
    'md' => 'w-64',
    'lg' => 'w-72',
    'xl' => 'w-80',
];

$classes = Gsmui::classes()
    ->add('flex flex-col')
    ->add($widthMap[$width] ?? 'w-64')
    ->add('bg-white dark:bg-zinc-800 border-r border-zinc-200 dark:border-white/10')
    ->add('h-full')
    ;
@endphp

<aside
    {{ $attributes->class($classes) }}
    data-gsmui-sidebar
    x-data="{
        collapsed: false,
        init() {
            @if ($type === 'overlay' || $type === 'drawer')
                this.$el.addEventListener('transitionend', () => {});
            @endif
        },
    }"
>
    <div class="flex items-center justify-between p-4 border-b border-zinc-200 dark:border-white/10">
        <div class="flex items-center gap-2">
            @if ($collapsible)
                <button
                    type="button"
                    class="size-8 flex items-center justify-center rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                    x-on:click="collapsed = !collapsed"
                    aria-label="{{ collapsed ? __('Expand') : __('Collapse') }}"
                >
                    <gsmui:icon.chevron-left variant="mini" class="transition-transform" :class="collapsed ? '-rotate-180' : ''" />
                </button>
            @endif
            <div x-show="!collapsed" x-cloak x-transition>
                {{ $header ?? '' }}
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-2" x-show="!collapsed" x-cloak x-transition>
        {{ $slot }}
    </nav>

    @if ($collapsed)
        <nav class="flex-1 overflow-y-auto p-2 hidden" x-show="collapsed" x-cloak>
            {{ $slot }}
        </nav>
    @endif
</aside>
