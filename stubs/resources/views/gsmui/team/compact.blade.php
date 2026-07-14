@blaze(fold: true)

<x-gsmui:team style="compact" {{ $attributes->merge(['style' => 'compact']) }}>
    {{ $slot }}
</x-gsmui:team>
