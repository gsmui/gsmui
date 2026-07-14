@blaze(fold: true)

<x-gsmui:credit-card style="stats" {{ $attributes->merge(['style' => 'stats']) }}>
    {{ $slot }}
</x-gsmui:credit-card>