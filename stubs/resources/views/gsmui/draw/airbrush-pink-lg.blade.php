@blaze(fold: true)

@props([
    'width'  => '400',
    'height' => '300',
    'bg'     => 'white',
])

<x-gsmui:draw
    tool="airbrush"
    color="pink"
    size="lg"
    :width="$width"
    :height="$height"
    :bg="$bg"
    {{ $attributes }}
/>
