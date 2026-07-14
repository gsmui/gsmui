@blaze(fold: true)

@props([
    'src' => null,
    'poster' => null,
    'autoplay' => false,
    'muted' => false,
    'loop' => false,
    'controls' => true,
    'aspectRatio' => '16/9',
])

<x-gsmui:video.standard
    :src="$src"
    :poster="$poster"
    :autoplay="$autoplay"
    :muted="$muted"
    :loop="$loop"
    :controls="$controls"
    :aspectRatio="$aspectRatio"
    {{ $attributes }}
/>
