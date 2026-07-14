@blaze(fold: true)

@props([
    'width'  => '400',
    'height' => '300',
    'bg'     => 'white',
])

<x-gsmui:draw
    tool="fill"
    color="brown"
    size="lg"
    :width="$width"
    :height="$height"
    :bg="$bg"
    {{ $attributes }}
/>
