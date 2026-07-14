@blaze(fold: true)

@props([
    'href' => null,
    'active' => false,
    'icon' => null,
    'iconVariant' => 'mini',
    'badge' => null,
    'badgeColor' => null,
    'label' => null,
    'disabled' => false,
    'external' => false,
    'variant' => null,
    'color' => null,
    'hasSubItems' => false,
    'defaultExpanded' => false,
    'as' => null,
])

@php
$tag = $as ?: ($href ? 'a' : 'button');
$isCurrent = $active;

$classes = Gsmui::classes()
    ->add('flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-150')
    ->add(match ($variant) {
        'ghost' => $isCurrent ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-white',
        'filled' => $isCurrent ? match ($color) {
            'primary' => 'bg-blue-600 text-white shadow-sm',
            'violet' => 'bg-violet-600 text-white shadow-sm',
            'emerald' => 'bg-emerald-600 text-white shadow-sm',
            default => 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 shadow-sm',
        } : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800',
        'inset' => $isCurrent ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white -mx-2 px-4' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white -mx-2 px-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50',
        'subtle' => $isCurrent ? 'text-zinc-900 dark:text-white font-semibold' : 'text-zinc-400 dark:text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300',
        default => $isCurrent ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-white',
    })
    ->add($disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'cursor-pointer')
    ;

$iconClasses = Gsmui::classes()
    ->add('shrink-0 size-5')
    ->add($isCurrent ? '' : 'opacity-70 group-hover:opacity-100')
    ;

$arrowClasses = Gsmui::classes()
    ->add('ml-auto shrink-0 size-4 transition-transform duration-200 text-zinc-400')
    ;
@endphp

@if ($hasSubItems)
    {{-- Item with sub-items: wrap in an Alpine container for expand/collapse --}}
    <div x-data="{ expanded: {{ $defaultExpanded ? 'true' : 'false' }} }" data-gsmui-sidebar-item-group>
        {{-- Trigger button --}}
        <button
            type="button"
            @click="expanded = !expanded"
            @if ($disabled) disabled aria-disabled="true" @endif
            {{ $attributes->class($classes) }}
            @if ($isCurrent) aria-current="page" @endif
            data-gsmui-sidebar-item
        >
            @if ($icon)
                <gsmui:icon :name="$icon" :variant="$iconVariant" class="{{ $iconClasses }}" />
            @elseif ($slot?->icon ?? false)
                <span class="{{ $iconClasses }}">{{ $slot->icon }}</span>
            @endif

            <span class="flex-1 truncate">{{ $label }}</span>

            @if ($badge !== null)
                <gsmui:badge :color="$badgeColor ?? 'zinc'" size="sm">{{ $badge }}</gsmui:badge>
            @endif

            <gsmui:icon name="chevron-right" variant="mini" class="{{ $arrowClasses }}" :class="expanded ? 'rotate-90' : ''" />
        </button>

        {{-- Collapsible sub-items container --}}
        <div
            x-show="expanded"
            x-collapse.duration.200ms
            class="flex flex-col gap-1 mt-1 ps-4 border-s border-zinc-200 dark:border-zinc-700 ms-3"
        >
            {{ $slot }}
        </div>
    </div>
@else
    {{-- Plain item (no sub-items) --}}
    <{{ $tag }}
        @if ($href) href="{{ $href }}" @if ($external) target="_blank" rel="noopener noreferrer" @endif @endif
        @if ($tag === 'button') type="button" @endif
        @if ($disabled) disabled aria-disabled="true" @endif
        {{ $attributes->class($classes) }}
        @if ($isCurrent) aria-current="page" @endif
        data-gsmui-sidebar-item
    >
        @if ($icon)
            <gsmui:icon :name="$icon" :variant="$iconVariant" class="{{ $iconClasses }}" />
        @elseif ($slot?->icon ?? false)
            <span class="{{ $iconClasses }}">{{ $slot->icon }}</span>
        @endif

        <span class="flex-1 truncate">{{ $label ?? $slot }}</span>

        @if ($badge !== null)
            <gsmui:badge :color="$badgeColor ?? 'zinc'" size="sm">{{ $badge }}</gsmui:badge>
        @endif
    </{{ $tag }}>
@endif
