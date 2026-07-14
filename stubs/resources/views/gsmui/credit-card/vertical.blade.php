@blaze(fold: true)

<x-gsmui:credit-card style="vertical" {{ $attributes->merge(['style' => 'vertical']) }}>
    {{ $slot }}
</x-gsmui:credit-card>