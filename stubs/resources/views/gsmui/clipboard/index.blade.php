@blaze(fold: true)

@props([
    'value' => '',
    'label' => null,
    'copiedLabel' => 'Copied!',
    'timeout' => 2000,
    'variant' => 'outline',
    'size' => null,
])

<div class="inline-flex items-center gap-2" data-gsmui-clipboard>
    <span class="text-sm text-zinc-600 dark:text-zinc-400 select-all">{{ $value }}</span>

    <gsmui:button
        variant="{{ $variant }}"
        size="{{ $size }}"
        x-data="{ copied: false }"
        x-on:click="navigator.clipboard.writeText('{{ addslashes($value) }}'); copied = true; setTimeout(() => copied = false, {{ $timeout }})"
        aria-label="{{ $label ?? __('Copy to clipboard') }}"
    >
        <gsmui:icon.clipboard-document variant="mini" x-show="!copied" />
        <span x-show="!copied">{{ $label ?? __('Copy') }}</span>
        <gsmui:icon.check variant="mini" x-show="copied" class="text-green-500" />
        <span x-show="copied">{{ $copiedLabel }}</span>
    </gsmui:button>
</div>
