@blaze(fold: true, unsafe: ['name'])

@props([
    'name' => null,
    'variant' => 'bezel',
    'color' => null,
    'size' => null,
    'orientation' => null,
    'camera' => 'dot',
    'cameraPosition' => 'center',
    'displayColor' => null,
    'displaySrc' => null,
    'displayAlt' => null,
    'displayAspect' => '4:3',
    'scrollable' => false,
    'statusBar' => false,
    'statusBarTime' => null,
    'statusBarBattery' => 85,
])

@php
$slotContent = $slot->isNotEmpty() ? $slot : null;

$cameraBefore = Gsmui::classes()
    ->add('flex items-center justify-center')
    ->add(match ($size) {
        'sm' => 'h-6',
        'lg' => 'h-8',
        'xl' => 'h-10',
        default => 'h-7',
    })
    ;
@endphp

<gsmui:tablet :$variant :$color :$size :$orientation {{ $attributes }} data-gsmui-tablet-screen>
    <div class="{{ $cameraBefore }}">
        <gsmui:tablet.camera :variant="$camera" :position="$cameraPosition" />
    </div>

    <gsmui:tablet.display
        :color="$displayColor"
        :src="$displaySrc"
        :alt="$displayAlt"
        :aspect="$displayAspect"
        :scrollable="$scrollable"
        :$orientation
    >
        @if ($statusBar)
            <gsmui:tablet.status
                :$size
                :time="$statusBarTime"
                :battery="$statusBarBattery"
                :$orientation
            />
        @endif

        @if ($slotContent)
            {{ $slotContent }}
        @else
            <div class="flex items-center justify-center h-full text-zinc-400 dark:text-zinc-600 text-sm">
                {{ $name ?? 'Tablet Screen' }}
            </div>
        @endif
    </gsmui:tablet.display>
</gsmui:tablet>
