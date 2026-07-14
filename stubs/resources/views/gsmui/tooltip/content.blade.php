@blaze(fold: true)

@props([
    'kbd' => null,
])

<div {{ $attributes->class('space-y-1') }} data-gsmui-tooltip-rich-content>
    {{ $slot }}

    @if ($kbd)
        <kbd class="mt-1 inline-flex rounded border border-white/20 px-1 py-0.5 text-[10px]">{{ $kbd }}</kbd>
    @endif
</div>
