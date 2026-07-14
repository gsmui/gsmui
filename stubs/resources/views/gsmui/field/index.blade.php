@blaze(fold: true)

@props([
    'variant' => null,
])

@php
$isInline = $variant === 'inline';
@endphp

<div {{ $attributes->class($isInline ? 'flex items-center gap-4' : 'block') }} data-gsmui-field>
    {{ $slot }}
</div>
