@blaze(fold: true)

@props([
    'src' => null,
    'autoplay' => false,
    'showTitle' => false,
    'title' => null,
    'artist' => null,
])

<x-gsmui:audio.standard
    :src="$src"
    :autoplay="$autoplay"
    :showTitle="$showTitle"
    :title="$title"
    :artist="$artist"
    {{ $attributes }}
/>
