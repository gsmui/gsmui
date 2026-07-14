@blaze(fold: true)

<x-gsmui:credit-card style="cover" {{ $attributes->merge(['style' => 'cover']) }}>
    {{ $slot }}
</x-gsmui:credit-card>