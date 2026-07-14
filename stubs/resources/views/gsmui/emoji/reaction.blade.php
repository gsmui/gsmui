@props([
    'emoji' => '👍',
    'count' => 0,
    'active' => false,
    'label' => null,
])

<div 
    {{ $attributes->class(["inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border transition-all duration-200 cursor-pointer select-none"]) }}
    :class="{{ $active }} ? 'bg-blue-50 dark:bg-blue-900/30 border-blue-300 dark:border-blue-700' : 'bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600'"
    x-data="{ active: {{ $active ? 'true' : 'false' }}, count: {{ $count }} }"
    @click="active = !active; count = active ? count + 1 : count - 1;"
>
    <span class="text-lg">{{ $emoji }}</span>
    <span 
        class="text-sm font-medium tabular-nums"
        :class="active ? 'text-blue-600 dark:text-blue-400' : 'text-zinc-600 dark:text-zinc-400'"
        x-text="count"
    ></span>
    @if($label)
        <span class="text-xs text-zinc-500 dark:text-zinc-400 hidden sm:inline">{{ $label }}</span>
    @endif
</div>
