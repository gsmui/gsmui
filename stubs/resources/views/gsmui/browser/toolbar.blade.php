@blaze(fold: true)

@props([
    'url' => null,
    'placeholder' => 'https://',
    'trafficLights' => true,
    'trafficLightColor' => null,
    'size' => null,
])

@php
$toolbarClasses = Gsmui::classes()
    ->add('flex items-center w-full')
    ->add(match ($size) {
        'sm' => 'h-10 px-3 gap-2',
        'lg' => 'h-14 px-5 gap-3',
        default => 'h-12 px-4 gap-2.5',
    })
    ;

$lightSize = match ($size) {
    'sm' => 'size-2.5',
    'lg' => 'size-3.5',
    default => 'size-3',
};

$lightGap = match ($size) {
    'sm' => 'gap-1.5',
    'lg' => 'gap-2',
    default => 'gap-1.5',
};

$addressClasses = Gsmui::classes()
    ->add('flex-1 flex items-center rounded-md border px-3 py-1 text-xs sm:text-sm font-mono truncate select-none')
    ->add(match ($size) {
        'sm' => 'h-6 text-[11px]',
        'lg' => 'h-8 text-sm',
        default => 'h-7 text-xs sm:text-sm',
    })
    ->add('bg-zinc-100 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400')
    ;

$trafficLightColors = match ($trafficLightColor) {
    'mac' => ['close' => '#ff5f57', 'minimize' => '#febc2e', 'maximize' => '#28c840'],
    'windows' => ['close' => '#e81123', 'minimize' => '#e81123', 'maximize' => '#e81123'],
    'ubuntu' => ['close' => '#e95420', 'minimize' => '#e95420', 'maximize' => '#e95420'],
    'mono' => ['close' => '#9ca3af', 'minimize' => '#9ca3af', 'maximize' => '#9ca3af'],
    default => ['close' => '#ff5f57', 'minimize' => '#febc2e', 'maximize' => '#28c840'],
};
@endphp

<div {{ $attributes->class($toolbarClasses) }} data-gsmui-browser-toolbar>
    @if ($trafficLights)
        <div class="flex items-center {{ $lightGap }} shrink-0" data-gsmui-browser-lights>
            <span class="{{ $lightSize }} rounded-full" style="background-color: {{ $trafficLightColors['close'] }}"></span>
            <span class="{{ $lightSize }} rounded-full" style="background-color: {{ $trafficLightColors['minimize'] }}"></span>
            <span class="{{ $lightSize }} rounded-full" style="background-color: {{ $trafficLightColors['maximize'] }}"></span>
        </div>
    @endif

    @if ($url !== null || $slot->isNotEmpty())
        <div class="{{ $addressClasses }}">
            @if ($slot->isNotEmpty())
                {{ $slot }}
            @else
                <span class="truncate">{{ $url }}</span>
            @endif
        </div>
    @else
        <div class="{{ $addressClasses }}">
            <span class="text-zinc-400 dark:text-zinc-500 truncate">{{ $placeholder }}</span>
        </div>
    @endif
</div>
