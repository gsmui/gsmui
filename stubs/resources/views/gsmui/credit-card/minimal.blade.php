@blaze(fold: true)

<x-gsmui:credit-card style="minimal" {{ $attributes->merge(['style' => 'minimal']) }}>
    {{ $slot }}
</x-gsmui:credit-card>