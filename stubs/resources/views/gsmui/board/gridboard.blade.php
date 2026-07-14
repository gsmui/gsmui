@blaze(fold: true)

@props([
    'width'  => '400',
    'height' => '300',
    'bg'     => 'white',
])

<x-gsmui:board
    type="gridboard"
    :width="$width"
    :height="$height"
    :bg="$bg"
    {{ $attributes }}
 />