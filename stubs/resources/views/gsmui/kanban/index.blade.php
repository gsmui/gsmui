@blaze(fold: true, safe: ['header', 'footer'])

@props([
    'header' => null,
    'footer' => null,
])

@php
$classes = Gsmui::classes()
    ->add('flex gap-4 overflow-x-auto pb-2')
    ->add('min-h-[200px]')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-kanban>
    @if ($header)
        <div class="flex items-center gap-2 px-1 mb-2 text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ $header }}</div>
    @endif

    {{ $slot }}

    @if ($footer)
        <div class="flex items-center gap-2 px-1 mt-2 text-sm text-zinc-400">{{ $footer }}</div>
    @endif
</div>
