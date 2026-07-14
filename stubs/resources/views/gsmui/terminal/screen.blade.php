@blaze(fold: true)

@props([
    'title' => null,
    'scrollable' => false,
    'minHeight' => null,
])

@php
$classes = Gsmui::classes()
    ->add('relative')
    ->add($scrollable ? 'overflow-y-auto max-h-96' : '')
    ->add($minHeight ? $minHeight : 'min-h-32')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-terminal-screen>
    @if ($title)
        <div class="flex items-center gap-2 pb-2 mb-2 border-b border-white/10 text-zinc-500 text-xs uppercase tracking-wider">
            <gsmui:icon name="command-line" variant="mini" class="size-3.5" />
            <span>{{ $title }}</span>
        </div>
    @endif

    <div class="space-y-0.5">
        {{ $slot }}
    </div>
</div>
