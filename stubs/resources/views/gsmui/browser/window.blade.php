@blaze(fold: true, unsafe: ['name'])

@props([
    'name' => null,
    'variant' => 'default',
    'color' => null,
    'size' => null,
    'url' => null,
    'placeholder' => 'https://',
    'trafficLights' => true,
    'trafficLightColor' => null,
    'src' => null,
    'alt' => null,
    'minHeight' => null,
    'scrollable' => false,
    'noBorder' => false,
])

@php
$slotContent = $slot->isNotEmpty() ? $slot : null;
@endphp

<gsmui:browser :$variant :$color :$size {{ $attributes }} data-gsmui-browser-window>
    <gsmui:browser.toolbar
        :$url
        :$placeholder
        :$trafficLights
        :trafficLightColor="$trafficLightColor"
        :$size
    />

    <gsmui:browser.content
        :$src
        :$alt
        :$minHeight
        :$scrollable
        :$noBorder
    >
        @if ($slotContent)
            {{ $slotContent }}
        @else
            <div class="flex items-center justify-center h-full text-zinc-400 dark:text-zinc-600 text-sm p-8">
                {{ $name ?? 'Browser Window' }}
            </div>
        @endif
    </gsmui:browser.content>
</gsmui:browser>
