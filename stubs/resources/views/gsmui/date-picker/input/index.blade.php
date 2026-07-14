@blaze(fold: true)

@props([
    'variant' => 'native',
])

<gsmui:delegate-component :component="'date-picker.input.variants.' . $variant">{{ $slot }}</gsmui:delegate-component>
