@blaze(fold: true, unsafe: ['name'])

@props([
    'name' => null,
    'variant' => 'default',
    'color' => null,
    'size' => null,
    'title' => null,
    'trafficLights' => true,
    'trafficLightColor' => null,
    'src' => null,
    'alt' => null,
    'minHeight' => null,
    'height' => null,
    'scrollable' => false,
    'centered' => false,
    'padded' => true,
])

@php
$slotContent = $slot->isNotEmpty() ? $slot : null;
@endphp

<gsmui:window
    :$variant
    :$color
    :$size
    :$trafficLights
    :trafficLightColor="$trafficLightColor"
    :$title
    {{ $attributes }}
    data-gsmui-window-panel
>
    @if ($slotContent)
        <gsmui:window.content :$src :$alt :$minHeight :height="$height" :$scrollable :$centered :$padded>
            {{ $slotContent }}
        </gsmui:window.content>
    @elseif ($src)
        <gsmui:window.content :$src :$alt :$minHeight :height="$height" :$scrollable :$centered :$padded />
    @else
        <gsmui:window.content :$src :$alt :$minHeight :height="$height" :$scrollable :$centered :$padded>
            <div class="flex items-center justify-center h-full text-zinc-400 dark:text-zinc-600 text-sm">
                {{ $name ?? 'Window' }}
            </div>
        </gsmui:window.content>
    @endif
</gsmui:window>
