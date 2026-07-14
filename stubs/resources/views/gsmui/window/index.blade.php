@blaze(fold: true)

@props([
    'variant' => 'default',
    'size' => null,
    'trafficLights' => true,
    'trafficLightColor' => null,
    'title' => null,
])

@php
$classes = Gsmui::classes()
    ->add('relative inline-flex flex-col w-full overflow-hidden rounded-xl')
    ->add(match ($size) {
        'sm' => 'max-w-lg',
        'lg' => 'max-w-5xl',
        'xl' => 'max-w-7xl',
        default => 'max-w-3xl',
    })
    ->add(match ($variant) {
        'flat' => 'shadow-lg border border-zinc-300 dark:border-zinc-700',
        'minimal' => 'shadow-md border border-zinc-200 dark:border-zinc-700',
        'light' => 'shadow-md border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800',
        default => 'shadow-xl border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900',
    })
    ;

$headerClasses = Gsmui::classes()
    ->add('flex items-center gap-2 px-4 select-none border-b')
    ->add(match ($variant) {
        'light' => 'bg-zinc-100 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700',
        default => 'bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700',
    })
    ->add(match ($size) {
        'sm' => 'h-9',
        'lg' => 'h-14',
        default => 'h-11',
    })
    ;

$dotSize = match ($size) {
    'sm' => 'size-2.5',
    'lg' => 'size-3.5',
    default => 'size-3',
};

$dotGap = match ($size) {
    'sm' => 'gap-1.5',
    'lg' => 'gap-2.5',
    default => 'gap-2',
};

$trafficLightColors = match ($trafficLightColor) {
    'mac' => ['close' => '#ff5f57', 'minimize' => '#febc2e', 'maximize' => '#28c840'],
    'windows' => ['close' => '#e81123', 'minimize' => '#e81123', 'maximize' => '#e81123'],
    'ubuntu' => ['close' => '#e95420', 'minimize' => '#e95420', 'maximize' => '#e95420'],
    'mono' => ['close' => '#9ca3af', 'minimize' => '#9ca3af', 'maximize' => '#9ca3af'],
    default => ['close' => '#ff5f57', 'minimize' => '#febc2e', 'maximize' => '#28c840'],
};

$contentClasses = Gsmui::classes()
    ->add('border-t border-zinc-200 dark:border-zinc-700')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-window>
    @if ($trafficLights || $title)
        <div class="{{ $headerClasses }}">
            @if ($trafficLights)
                <div class="flex items-center {{ $dotGap }} shrink-0">
                    <span class="{{ $dotSize }} rounded-full" style="background-color: {{ $trafficLightColors['close'] }}"></span>
                    <span class="{{ $dotSize }} rounded-full" style="background-color: {{ $trafficLightColors['minimize'] }}"></span>
                    <span class="{{ $dotSize }} rounded-full" style="background-color: {{ $trafficLightColors['maximize'] }}"></span>
                </div>
            @endif

            @if ($title)
                <span class="flex-1 text-center truncate text-xs font-medium text-zinc-500 dark:text-zinc-400">{{ $title }}</span>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    @endif

    <div class="{{ $contentClasses }}">
        {{ $slot }}
    </div>
</div>
