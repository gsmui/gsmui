@blaze(fold: true)

@props([
    'placement' => 'bottom-start',
    'width' => 'auto',
])

@php
$classes = Gsmui::classes()
    ->add('relative inline-flex')
    ->add($width === 'fixed' ? 'w-48' : 'w-auto min-w-48')
    ;
@endphp

<div
    {{ $attributes->class($classes) }}
    data-gsmui-menu
    x-data="{
        open: false,
        toggle() { this.open = !this.open; },
        close() { this.open = false; },
        init() {
            $el.addEventListener('keydown', e => {
                if (!this.open) return;
                if (e.key === 'Escape') this.close();
            });
        },
    }"
    x-on:click.outside="close()"
>
    <div x-on:click="toggle()">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-cloak
        x-transition
        class="
            absolute z-50 mt-1 rounded-lg border border-zinc-200 dark:border-white/10
            bg-white dark:bg-zinc-800 shadow-lg py-1
            {{ match ($placement) {
                'bottom-start' => 'left-0 top-full',
                'bottom-end' => 'right-0 top-full',
                'top-start' => 'left-0 bottom-full mb-1',
                'top-end' => 'right-0 bottom-full mb-1',
                default => 'left-0 top-full',
            } }}
        "
        role="menu"
        aria-orientation="vertical"
    >
        {{ $slot }}
    </div>
</div>
