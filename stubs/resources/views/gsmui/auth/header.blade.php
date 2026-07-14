@props([
    'name' => null,
    'logo' => null,
    'href' => '/',
])

<div {{ $attributes->class('mb-8') }}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        <gsmui:brand :$name :$logo :$href />
    @endif
</div>
