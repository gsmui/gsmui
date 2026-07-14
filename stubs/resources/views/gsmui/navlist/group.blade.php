@blaze(fold: true)

@props([
    'heading' => null,
    'expandable' => false,
    'expanded' => true,
])

@php
$renderedHeading = $heading ?? ($slot?->heading ?? false);
$hasHeading = $renderedHeading !== false;
@endphp

<div {{ $attributes->class('') }} data-gsmui-navlist-group>
    @if ($hasHeading)
        @if ($expandable)
            <div x-data="{ open: {{ $expanded ? 'true' : 'false' } }" class="select-none">
                <button type="button" @click="open = !open" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-400 transition-colors" data-gsmui-navlist-group-heading>
                    <span class="flex-1 text-start">{{ $renderedHeading }}</span>
                    <gsmui:icon.chevron-down variant="mini" class="size-4 transition-transform duration-200" x-bind:class="open ? 'rotate-0' : '-rotate-90'" />
                </button>

                <div x-show="open" x-collapse x-cloak class="mt-1 space-y-0.5">
                    {{ $slot }}
                </div>
            </div>
        @else
            <div class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500" data-gsmui-navlist-group-heading>
                {{ $renderedHeading }}
            </div>
            <div class="mt-1 space-y-0.5">
                {{ $slot }}
            </div>
        @endif
    @else
        {{ $slot }}
    @endif
</div>
