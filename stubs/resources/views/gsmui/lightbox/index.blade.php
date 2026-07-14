@blaze(fold: true)

@props([
    'images' => [],
    'open' => false,
    'index' => 0,
])

@php
$classes = Gsmui::classes()
    ->add('fixed inset-0 z-50 flex items-center justify-center bg-black/90')
    ;
@endphp

<div
    x-data="{
        images: {{ json_encode($images) }},
        currentIndex: {{ $index }},
        open: {{ $open ? 'true' : 'false' }},
        get currentImage() {
            return this.images[this.currentIndex];
        },
        prev() {
            if (this.currentIndex > 0) this.currentIndex--;
        },
        next() {
            if (this.currentIndex < this.images.length - 1) this.currentIndex++;
        },
    }"
    x-show="open"
    x-cloak
    @keydown.escape.window="open = false"
    @keydown.left.window="if (open) prev()"
    @keydown.right.window="if (open) next()"
    {{ $attributes->class($classes) }}
    data-gsmui-lightbox
    role="dialog"
    aria-modal="true"
    aria-label="{{ __('Image viewer') }}"
>
    <button
        type="button"
        class="absolute top-4 right-4 flex items-center justify-center size-10 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors"
        x-on:click="open = false"
        aria-label="{{ __('Close') }}"
    >
        <gsmui:icon.x-mark variant="mini" />
    </button>

    @if (count($images) > 1)
        <button
            type="button"
            class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center justify-center size-10 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors disabled:opacity-30"
            x-on:click="prev()"
            x-bind:disabled="currentIndex <= 0"
            aria-label="{{ __('Previous image') }}"
        >
            <gsmui:icon.chevron-left variant="mini" />
        </button>

        <button
            type="button"
            class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center size-10 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors disabled:opacity-30"
            x-on:click="next()"
            x-bind:disabled="currentIndex >= images.length - 1"
            aria-label="{{ __('Next image') }}"
        >
            <gsmui:icon.chevron-right variant="mini" />
        </button>
    @endif

    <div class="flex flex-col items-center gap-4 p-4 max-w-[90vw] max-h-[90vh]">
        <img
            x-bind:src="currentImage"
            x-bind:alt="currentImage"
            class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl"
        />

        @if (count($images) > 1)
            <div class="text-sm text-white/80 tabular-nums" x-text="`{{ __(':current of :total', ['current' => '', 'total' => '']) }} ${currentIndex + 1} / ${images.length}`"></div>
        @endif
    </div>
</div>
