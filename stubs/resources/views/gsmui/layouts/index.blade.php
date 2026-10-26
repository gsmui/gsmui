@blaze(fold: true, unsafe: ['header', 'footer', 'sidebar'])

@props([
    'variant' => 'sidebar',
    'header' => null,
    'footer' => null,
    'sidebar' => null,
    'sidebarPosition' => 'left',
])

@php
$classes = Gsmui::classes()
    ->add('min-h-screen flex flex-col bg-zinc-50 dark:bg-zinc-900')
    ;

$bodyClasses = Gsmui::classes()
    ->add('flex flex-1')
    ;

$mainClasses = Gsmui::classes()
    ->add('flex-1 flex flex-col')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-layout>
    @if ($header)
        <gsmui:layouts.header>{{ $header }}</gsmui:layouts.header>
    @endif

    <div class="{{ $bodyClasses }}">
        @if ($sidebar && $sidebarPosition === 'left')
            <gsmui:layouts.sidebar>{{ $sidebar }}</gsmui:layouts.sidebar>
        @endif

        <main class="{{ $mainClasses }}">
            {{ $slot }}
        </main>

        @if ($sidebar && $sidebarPosition === 'right')
            <gsmui:layouts.sidebar>{{ $sidebar }}</gsmui:layouts.sidebar>
        @endif
    </div>

    @if ($footer)
        <gsmui:layouts.footer>{{ $footer }}</gsmui:layouts.footer>
    @endif
</div>
