@blaze(fold: true)

@props([
    'separator' => null,
    'size' => null,
])

@php
$classes = Gsmui::classes()
    ->add('flex items-center flex-wrap gap-1')
    ->add(match ($size) {
        'sm' => 'text-xs',
        'lg' => 'text-base',
        default => 'text-sm',
    })
    ;

$separatorIcon = $separator ?: 'chevron-right';
@endphp

<nav {{ $attributes->class($classes) }} data-gsmui-breadcrumbs aria-label="Breadcrumb">
    <ol class="flex items-center flex-wrap gap-1">
        {{ $slot }}
    </ol>
</nav>
