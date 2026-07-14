@blaze(fold: true)

@props([
    'width'  => '400',
    'height' => '300',
    'bg'     => 'white',
])

<x-gsmui:draw
    tool="text"
    color="white"
    size="sm"
    :width="$width"
    :height="$height"
    :bg="$bg"
    {{ $attributes }}
/>
