@blaze(fold: true)

@props([
    'icon' => null,
    'title' => null,
    'description' => null,
    'actionLabel' => null,
    'actionHref' => null,
])

@php
$classes = Gsmui::classes()
    ->add('flex flex-col items-center justify-center text-center gap-4 p-8')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-empty-state>
    @if ($icon)
        <div class="text-zinc-300 dark:text-zinc-600">
            <gsmui:icon :name="$icon" variant="lg" />
        </div>
    @endif

    @if ($title)
        <div class="flex flex-col gap-1">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $title }}</h3>
            @if ($description)
                <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm">{{ $description }}</p>
            @endif
        </div>
    @endif

    @if ($actionLabel && $actionHref)
        <a href="{{ $actionHref }}" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
            {{ $actionLabel }}
            <gsmui:icon.arrow-right variant="mini" />
        </a>
    @elseif ($actionLabel)
        <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ $actionLabel }}</span>
    @endif
</div>
