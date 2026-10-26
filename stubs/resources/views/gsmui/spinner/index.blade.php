@blaze(fold: true)

@props([
    'size' => 'md',
    'class' => '',
])

@php
// An indeterminate spinner. Used for loading states inside combobox/datagrid.
$sizeClasses = match ($size) {
    'xs' => 'size-3',
    'sm' => 'size-4',
    'lg' => 'size-6',
    'xl' => 'size-8',
    default => 'size-5',
};

$classes = Gsmui::classes()
    ->add('inline-block shrink-0 animate-spin rounded-full border-2 border-current border-t-transparent')
    ->add($sizeClasses)
    ->add($class)
    ;
@endphp

<span {{ $attributes->class($classes) }} role="status" aria-label="{{ __('Loading') }}"></span>
