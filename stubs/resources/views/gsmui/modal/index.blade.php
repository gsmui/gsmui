@blaze(fold: true, unsafe: ['name', 'label', 'badge'])

@props([
    'name' => null,
    'flyout' => false,
    'variant' => null,
    'position' => 'right',
    'scroll' => null,
    'dismissible' => true,
    'closable' => true,
])

@php
$isFlyout = $flyout || $variant === 'flyout';
$isFloating = $variant === 'floating';
$isBare = $variant === 'bare';

$backdropClasses = Gsmui::classes()
    ->add('fixed inset-0 z-50 flex')
    ->add($isFlyout ? match ($position) {
        'left' => 'justify-start items-stretch',
        'bottom' => 'items-end justify-center',
        default => 'justify-end items-stretch',
    } : 'items-center justify-center')
    ->add($isFloating ? 'p-4' : '')
    ;

$overlayClasses = Gsmui::classes()
    ->add('fixed inset-0 bg-black/50 dark:bg-black/70 transition-opacity')
    ;

$panelClasses = Gsmui::classes()
    ->add('bg-white dark:bg-zinc-800 shadow-xl transition-all')
    ->add($isFlyout ? match ($position) {
        'left' => 'h-full w-full max-w-md overflow-y-auto',
        'bottom' => 'w-full max-h-[85vh] overflow-y-auto rounded-t-2xl',
        default => 'h-full w-full max-w-md overflow-y-auto',
    } : 'rounded-xl max-w-lg w-full mx-4 max-h-[85vh] overflow-y-auto')
    ->add($isFloating ? 'rounded-2xl shadow-2xl' : '')
    ->add($isBare ? 'bg-transparent shadow-none' : '')
    ;

$modalName = $name ?: 'modal-' . str()->random(6);
@endphp

<div
    x-data="{ open: false, name: '{{ $modalName }}' }"
    x-show="open"
    x-cloak
    @keydown.escape.window="open = false"
    data-gsmui-modal
>
    <div class="{{ $backdropClasses }}" style="display: none" x-show="open" x-cloak>
        <div class="{{ $overlayClasses }}" x-show="open" x-transition.opacity @if ($dismissible) @click="open = false" @endif></div>

        <div
            class="{{ $panelClasses }}"
            x-show="open"
            @click.stop
            @if ($isFlyout)
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-full"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-full"
            @else
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            @endif
            role="dialog"
            aria-modal="true"
            @if ($scroll === 'body') data-gsmui-modal-scroll-body @endif
        >
            @if ($closable && !$isBare)
                <div class="flex justify-end p-2">
                    <gsmui:button variant="ghost" size="sm" square @click="open = false" aria-label="{{ __('Close') }}">
                        <gsmui:icon.x-mark variant="mini" />
                    </gsmui:button>
                </div>
            @endif

            <div class="{{ $isFlyout ? 'p-6 pt-0' : 'p-6 pt-0' }}">
                {{ $slot }}
            </div>

            @if ($slot?->footer ?? false)
                <div {{ $slot->footer->attributes->class('sticky bottom-0 bg-white dark:bg-zinc-800 border-t border-zinc-200 dark:border-white/10 p-4') }}>
                    {{ $slot->footer }}
                </div>
            @endif
        </div>
    </div>
</div>
