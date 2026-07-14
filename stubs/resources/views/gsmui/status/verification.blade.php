@props([
    'verified' => true,
    'type' => 'personal',
    'size' => 'md',
])

@php
$types = [
    'personal' => 'text-blue-500',
    'business' => 'text-blue-600',
    'government' => 'text-blue-700',
    'organization' => 'text-purple-500',
];

$sizes = [
    'sm' => 'h-3.5 w-3.5',
    'md' => 'h-4 w-4',
    'lg' => 'h-5 w-5',
];

$colorClass = $types[$type] ?? 'text-blue-500';
$sizeClass = $sizes[$size] ?? 'h-4 w-4';
@endphp

@if($verified)
    <svg {{ $attributes->class(['inline-block', $sizeClass, $colorClass]) }} fill="currentColor" viewBox="0 0 24 24">
        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
    </svg>
@endif
