@blaze(fold: true, memo: true)

<gsmui:button
    {{ $attributes->class('self-start cursor-pointer _my-1 _ms-2 _me-1.25') }}
    variant="subtle"
    size="sm"
    square
    aria-label="{{ __('Remove file') }}"
    data-gsmui-file-item-remove
>
    <gsmui:icon.x-mark variant="micro" />
</gsmui:button>