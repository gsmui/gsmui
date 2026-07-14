@blaze(fold: true)

@props([
    'variant' => 'terminal',
    'size' => null,
    'title' => null,
    'copyable' => false,
    'copyText' => null,
])

@php
$slotContent = $slot->isNotEmpty() ? $slot : null;

$headerClasses = Gsmui::classes()
    ->add('flex items-center gap-2 px-4 border-b select-none')
    ->add(match ($variant) {
        'light' => 'bg-zinc-100 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400',
        'editor' => 'bg-zinc-800 border-zinc-700 text-zinc-400',
        default => 'bg-zinc-800 border-zinc-700 text-zinc-400',
    })
    ->add(match ($size) {
        'sm' => 'h-8 text-xs',
        'lg' => 'h-12 text-sm',
        default => 'h-10 text-xs',
    })
    ;

$dotSize = match ($size) {
    'sm' => 'size-2',
    'lg' => 'size-3',
    default => 'size-2.5',
};

$dotGap = match ($size) {
    'sm' => 'gap-1',
    'lg' => 'gap-2',
    default => 'gap-1.5',
};
@endphp

<gsmui:code :$variant :$size {{ $attributes }} data-gsmui-terminal>
    <div class="{{ $headerClasses }}">
        <div class="flex items-center {{ $dotGap }} shrink-0">
            <span class="{{ $dotSize }} rounded-full bg-red-500/80"></span>
            <span class="{{ $dotSize }} rounded-full bg-amber-500/80"></span>
            <span class="{{ $dotSize }} rounded-full bg-green-500/80"></span>
        </div>

        @if ($title)
            <span class="flex-1 text-center truncate font-medium">{{ $title }}</span>
        @else
            <span class="flex-1"></span>
        @endif

        @if ($copyable && $copyText !== false)
            <gsmui:button
                variant="subtle"
                size="xs"
                square
                x-data="{ copied: false }"
                @click="
                    navigator.clipboard.writeText('{{ $copyText ?? '' }}');
                    copied = true;
                    setTimeout(() => copied = false, 2000);
                "
                aria-label="{{ __('Copy text') }}"
                class="shrink-0"
            >
                <template x-if="!copied">
                    <gsmui:icon name="clipboard" variant="mini" class="size-3.5" />
                </template>
                <template x-if="copied">
                    <gsmui:icon name="check" variant="mini" class="size-3.5 text-green-400" />
                </template>
            </gsmui:button>
        @endif
    </div>

    <div class="p-4">
        @if ($slotContent)
            {{ $slotContent }}
        @else
            <gsmui:code.line prefix="$" color="muted">{{ __('Terminal ready') }}</gsmui:code.line>
        @endif
    </div>
</gsmui:code>
