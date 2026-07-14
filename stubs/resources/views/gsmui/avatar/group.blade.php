@blaze(fold: true)

@props([])

<div {{ $attributes->class('flex -space-x-2 **:ring-2 **:ring-white dark:**:ring-zinc-900') }} data-gsmui-avatar-group>
    {{ $slot }}
</div>
