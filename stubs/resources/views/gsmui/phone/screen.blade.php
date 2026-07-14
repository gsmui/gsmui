@blaze(fold: true, unsafe: ['name'])

@props([
    'name' => null,
    'variant' => 'bezel',
    'color' => null,
    'size' => null,
    'camera' => 'dynamic-island',
    'cameraPosition' => 'center',
    'displayColor' => null,
    'displaySrc' => null,
    'displayAlt' => null,
    'displayAspect' => 'auto',
    'scrollable' => false,
    'statusBar' => false,
    'statusBarVariant' => null,
    'statusBarTime' => null,
    'statusBarBattery' => 75,
    'statusBarInverse' => false,
])

@php
$slotContent = $slot->isNotEmpty() ? $slot : null;

$cameraBefore = Gsmui::classes()
    ->add('flex items-center justify-center')
    ->add(match ($size) {
        'xs' => 'h-6',
        'sm' => 'h-7',
        'lg' => 'h-10',
        'xl' => 'h-11',
        default => 'h-8',
    })
    ;
@endphp

<gsmui:phone :$variant :$color :$size {{ $attributes }} data-gsmui-phone-screen>
    <div class="{{ $cameraBefore }}">
        <gsmui:phone.camera :variant="$camera" :position="$cameraPosition" />
    </div>

    <gsmui:phone.display
        :color="$displayColor"
        :src="$displaySrc"
        :alt="$displayAlt"
        :aspect="$displayAspect"
        :scrollable="$scrollable"
    >
        @if ($statusBar)
            <gsmui:phone.status
                :size="$size"
                :time="$statusBarTime"
                :battery="$statusBarBattery"
                :inverse="$statusBarInverse"
                :variant="$statusBarVariant"
            />
        @endif

        @if ($slotContent)
            {{ $slotContent }}
        @else
            <div class="flex items-center justify-center h-full text-zinc-400 dark:text-zinc-600 text-sm">
                {{ $name ?? 'Phone Screen' }}
            </div>
        @endif
    </gsmui:phone.display>
</gsmui:phone>
