@blaze(fold: true)

@props([
    'prefix' => '$',
    'color' => null,
    'cursor' => true,
    'blink' => true,
    'indent' => 0,
    'output' => false,
])

@php
$classes = Gsmui::classes()
    ->add('flex items-start')
    ;

$prefixClasses = Gsmui::classes()
    ->add('shrink-0 select-none mr-2')
    ->add($output ? 'opacity-60' : '')
    ;

if ($color) {
    $colorClasses = match ($color) {
        'success' => 'text-green-400',
        'warning' => 'text-amber-400',
        'danger' => 'text-red-400',
        'info' => 'text-sky-400',
        'muted' => 'opacity-60',
        'error' => 'text-red-400',
        default => '',
    };
} else {
    $colorClasses = $output ? 'opacity-80' : '';
}

$indentStr = str_repeat('    ', max(0, (int)$indent));
@endphp

<div {{ $attributes->class($classes) }} @if ($output) data-gsmui-terminal-output @else data-gsmui-terminal-prompt @endif>
    @if ($prefix)
        <span class="{{ $prefixClasses }} @if (!$output) {{ $colorClasses ?: 'text-emerald-400' }} @endif">
            {{ $prefix }}
        </span>
    @endif

    <span class="whitespace-pre-wrap break-all {{ $colorClasses ?: '' }}">
        {{ $indentStr }}{{ $slot }}
    </span>

    @if ($cursor && !$output)
        <span class="inline-block w-2 h-4 ml-0.5 bg-current {{ $blink ? 'animate-pulse' : '' }}" style="opacity: 0.8"></span>
    @endif
</div>
