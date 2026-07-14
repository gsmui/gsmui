@blaze(fold: true)

<x-gsmui:credit-card style="horizontal" {{ $attributes->merge(['style' => 'horizontal']) }}>
    {{ $slot }}
</x-gsmui:credit-card>