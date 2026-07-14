@blaze(fold: true)

@props([
    'duration' => 5000,
    'position' => 'top-right',
])

@php
$classes = Gsmui::classes()
    ->add('relative w-full max-w-sm rounded-lg border border-zinc-200 dark:border-white/10')
    ->add('bg-white dark:bg-zinc-800 shadow-lg p-4')
    ;
@endphp

<div
    {{ $attributes->class($classes) }}
    data-gsmui-toast
    x-data="{
        visible: true,
        remaining: {{ $duration }},
        timer: null,
        init() {
            if ({{ $duration }} > 0) {
                this.timer = setInterval(() => {
                    this.remaining -= 100;
                    if (this.remaining <= 0) this.close();
                }, 100);
            }
        },
        close() {
            this.visible = false;
            clearInterval(this.timer);
        },
    }"
    x-show="visible"
    x-cloak
    x-transition
    role="alert"
>
    <div class="flex items-start gap-3">
        <div class="flex-1">
            @if ($slot->isNotEmpty())
                {{ $slot }}
            @else
                <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $message ?? __('Notification') }}</p>
            @endif
        </div>
        <button
            type="button"
            class="shrink-0 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors"
            x-on:click="close()"
            aria-label="{{ __('Dismiss') }}"
        >
            <gsmui:icon.x-mark variant="mini" />
        </button>
    </div>

    @if ($duration > 0)
        <div class="mt-2 h-1 rounded-full bg-zinc-200 dark:bg-zinc-700 overflow-hidden">
            <div
                class="h-full bg-blue-500 dark:bg-blue-400 rounded-full transition-all"
                :style="`width: ${(remaining / {{ $duration }}) * 100}%`"
            ></div>
        </div>
    @endif
</div>
