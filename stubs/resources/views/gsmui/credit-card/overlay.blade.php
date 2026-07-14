@blaze(fold: true)

<x-gsmui:credit-card style="overlay" {{ $attributes->merge(['style' => 'overlay']) }}>
    {{ $slot }}
</x-gsmui:credit-card>