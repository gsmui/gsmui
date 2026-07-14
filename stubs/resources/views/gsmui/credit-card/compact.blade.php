@blaze(fold: true)

<x-gsmui:credit-card style="compact" {{ $attributes->merge(['style' => 'compact']) }}>
    {{ $slot }}
</x-gsmui:credit-card>