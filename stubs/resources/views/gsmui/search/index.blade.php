@blaze(fold: true)

@props([
    'placeholder' => null,
    'size' => null,
    'clearable' => true,
    'loading' => false,
    'disabled' => false,
    'name' => null,
])

@php
$name ??= $attributes->whereStartsWith('wire:model')->first();

$classes = Gsmui::classes()
    ->add('w-full flex items-center overflow-hidden')
    ->add('shadow-xs disabled:shadow-none')
    ->add('bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]')
    ->add(match ($size) {
        'sm' => 'h-8 text-sm rounded-md px-3',
        'lg' => 'h-12 text-lg rounded-lg px-3',
        default => 'h-10 text-base sm:text-sm rounded-lg px-3',
    })
    ->add('border border-zinc-200 border-b-zinc-300/80 dark:border-white/10')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-search data-gsmui-control>
    <div class="flex items-center justify-center ms-3 me-1 shrink-0">
        @if ($loading)
            <svg class="animate-spin size-4 text-zinc-400 dark:text-zinc-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @else
            <gsmui:icon.magnifying-glass variant="mini" class="text-zinc-400 dark:text-zinc-500 shrink-0" />
        @endif
    </div>

    <input
        type="search"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($disabled) disabled @endif
        {{ $attributes->only(['wire:model', 'name', 'type', 'placeholder', 'value', 'inputmode', 'autocomplete', 'autofocus', 'required'])->class('block w-full min-w-0 border-0 bg-transparent p-0 [font-size:inherit] [line-height:inherit] focus:ring-0 focus:ring-offset-0 focus:outline-none disabled:text-zinc-500 dark:disabled:text-zinc-400 placeholder-zinc-400 dark:placeholder-zinc-400') }}
    />

    @if ($clearable)
        <div class="flex items-center gap-1 me-2 ms-1 shrink-0">
            <gsmui:button as="div" variant="subtle" size="sm" square tabindex="-1" aria-label="{{ __('Clear') }}" class="cursor-pointer [[data-gsmui-search]:has(input:placeholder-shown)_&]:hidden" x-on:click.prevent="$el.closest('[data-gsmui-search]').querySelector('input').value = ''; $el.closest('[data-gsmui-search]').querySelector('input').dispatchEvent(new Event('input')); $el.closest('[data-gsmui-search]').querySelector('input').focus()">
                <gsmui:icon.x-mark variant="micro" />
            </gsmui:button>
        </div>
    @endif
</div>
