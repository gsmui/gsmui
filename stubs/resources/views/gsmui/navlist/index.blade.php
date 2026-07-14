@blaze(fold: true)

@props([])

<nav {{ $attributes->class('flex flex-col gap-0.5') }} data-gsmui-navlist>
    {{ $slot }}
</nav>
