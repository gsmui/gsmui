@blaze(fold: true, memo: true)

@aware([ 'variant' ])

@props([
    'variant' => 'check',
])

@php
// This prevents variants picked up by `@aware()` from other wrapping components like flux::modal from being used here...
$variant = $variant !== 'check' && Gsmui::componentExists('select.indicator.variants.' . $variant)
    ? $variant
    : 'check';
@endphp

<gsmui:delegate-component :component="'select.indicator.variants.' . $variant">{{ $slot }}</gsmui:delegate-component>
