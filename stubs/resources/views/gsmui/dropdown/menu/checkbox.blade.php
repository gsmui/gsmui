@blaze(fold: true)

@props([
    'checked' => false,
    'disabled' => false,
    'keepOpen' => false,
])

@php
$classes = Gsmui::classes()
    ->add('group flex w-full items-center gap-3 rounded-md px-2.5 py-2 text-sm transition-colors cursor-pointer')
    ->add($disabled ? 'opacity-50' : 'hover:bg-zinc-100 dark:hover:bg-white/10')
    ->add('text-zinc-700 dark:text-zinc-300')
    ;
@endphp

<label {{ $attributes->class($classes) }} data-gsmui-menu-checkbox @if ($keepOpen) x-on:click.stop @endif>
    <input type="checkbox" @if ($checked) checked @endif @if ($disabled) disabled @endif class="size-4 rounded border-zinc-300 dark:border-zinc-500 text-blue-600 focus:ring-blue-500/30" />

    <span class="flex-1">{{ $slot }}</span>
</label>
