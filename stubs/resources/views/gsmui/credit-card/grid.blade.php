@blaze(fold: true)

<x-gsmui:credit-card style="grid" {{ $attributes->merge(['style' => 'grid']) }}>
    {{ $slot }}
</x-gsmui:credit-card>