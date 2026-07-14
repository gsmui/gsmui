@blaze(fold: true)

@props([])

<span
    {{ $attributes }}
    @click="$el.closest('[data-gsmui-modal]').querySelector('[x-data]')?.__x?.$data?.open = false"
    data-gsmui-modal-close
>
    {{ $slot }}
</span>
