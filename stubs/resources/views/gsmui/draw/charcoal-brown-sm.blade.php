@blaze(fold: true)

@props([
    'width'  => '400',
    'height' => '300',
    'bg'     => 'white',
])

<x-gsmui:draw
    tool="charcoal"
    color="brown"
    size="sm"
    :width="$width"
    :height="$height"
    :bg="$bg"
    {{ $attributes }}
/>
