@blaze(fold: true)

@props([])

<div {{ $attributes->class('rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-700 p-1 min-w-48') }} data-gsmui-navmenu role="menu">
    {{ $slot }}
</div>
