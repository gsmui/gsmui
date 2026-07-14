@blaze(fold: true)

<x-gsmui:team style="featured" {{ $attributes->merge(['style' => 'featured']) }}>
    {{ $slot }}
</x-gsmui:team>
