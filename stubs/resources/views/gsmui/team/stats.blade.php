@blaze(fold: true)

<x-gsmui:team style="stats" {{ $attributes->merge(['style' => 'stats']) }}>
    {{ $slot }}
</x-gsmui:team>
