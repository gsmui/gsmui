@blaze(fold: true)

@props([
    'name' => null,
])

@php
$modalName = $name ?: 'modal';
@endphp

<span
    {{ $attributes }}
    @click="document.querySelector('[data-gsmui-modal]').__x.$data.open = true; $el.closest('[data-gsmui-modal]')?.__x.$data.open = true;"
    @if ($name) x-data x-on:click="let modals = document.querySelectorAll(`[x-data]`); modals.forEach(m => { if (m.__x?.$data?.name === '{{ $name }}') m.__x.$data.open = true })" @endif
    data-gsmui-modal-trigger
>
    {{ $slot }}
</span>
