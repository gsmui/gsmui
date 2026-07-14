@props([
    'src' => '',
    'title' => 'Embedded content',
    'width' => '100%',
    'height' => '400',
    'bordered' => true,
    'rounded' => true,
])

<iframe 
    src="{{ $src }}"
    title="{{ $title }}"
    width="{{ $width }}"
    height="{{ $height }}"
    {{ $attributes->class([
        'border-0',
        $bordered ? 'border border-zinc-200 dark:border-zinc-700' : '',
        $rounded ? 'rounded-xl' : '',
    ]) }}
    loading="lazy"
    sandbox="allow-scripts allow-same-origin"
></iframe>
