@blaze(fold: true)

@props([])

<div {{ $attributes->class('inline-flex [&>*]:-me-px [&>*]:rounded-none [&>:first-child]:rounded-s-lg [&>:last-child]:rounded-e-lg [&>*]:shadow-none') }} data-gsmui-button-group role="group">
    {{ $slot }}
</div>
