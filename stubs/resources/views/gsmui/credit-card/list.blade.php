@blaze(fold: true)

<x-gsmui:credit-card style="list" {{ $attributes->merge(['style' => 'list']) }}>
    {{ $slot }}
</x-gsmui:credit-card>