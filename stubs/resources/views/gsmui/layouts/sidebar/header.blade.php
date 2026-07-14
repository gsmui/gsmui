@blaze(fold: true)

@props([
    'brand' => null,
    'logo' => null,
    'logoAlt' => null,
    'closeable' => false,
    'href' => '/',
    'sticky' => false,
])

@php
$renderedLogo = $slot?->logo ?? false;
$hasLogoSlot = $renderedLogo !== false;

$classes = Gsmui::classes()
    ->add('flex items-center gap-3 px-4 py-3 border-b border-zinc-200 dark:border-zinc-800')
    ->add($sticky ? 'sticky top-0 bg-inherit z-10' : '')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-sidebar-header>
    {{-- Logo --}}
    @if ($logo)
        <img class="size-8 shrink-0 rounded-lg" src="{{ $logo }}" alt="{{ $logoAlt ?? $brand ?? '' }}" />
    @elseif ($hasLogoSlot)
        <div class="size-8 shrink-0">{{ $renderedLogo }}</div>
    @endif

    {{-- Brand --}}
    @if ($brand || ($slot?->brand ?? false))
        <div class="flex-1 truncate">
            @if ($href)
                <a href="{{ $href }}" class="text-sm font-semibold text-zinc-900 dark:text-white hover:opacity-80">{{ $brand ?? $slot->brand ?? '' }}</a>
            @else
                <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $brand ?? $slot->brand ?? '' }}</span>
            @endif
        </div>
    @endif

    {{-- Actions --}}
    @if ($slot?->actions ?? false)
        <div class="flex items-center gap-1 shrink-0">
            {{ $slot->actions }}
        </div>
    @endif

    {{-- Close button (for drawer/overlay mode) --}}
    @if ($closeable)
        <gsmui:button variant="subtle" size="xs" square @click="open = false" aria-label="{{ __('Close sidebar') }}" class="shrink-0">
            <gsmui:icon.x-mark variant="mini" class="size-4" />
        </gsmui:button>
    @endif
</div>
