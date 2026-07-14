@blaze(fold: true)

<x-gsmui:team style="overlay" {{ $attributes->merge(['style' => 'overlay']) }}>
    {{ $slot }}
</x-gsmui:team>
