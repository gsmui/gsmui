@blaze(fold: true)

<x-gsmui:credit-card style="featured" {{ $attributes->merge(['style' => 'featured']) }}>
    {{ $slot }}
</x-gsmui:credit-card>