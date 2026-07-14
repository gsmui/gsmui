@blaze(fold: true)

<x-gsmui:team style="vertical" {{ $attributes->merge(['style' => 'vertical']) }}>
    {{ $slot }}
</x-gsmui:team>
