@blaze(fold: true)

@props([
    'variant' => null,
])

<ui-disclosure-group {{ $attributes->class('block') }} data-gsmui-accordion-heading>
    {{ $slot }}
</ui-disclosure-group>
