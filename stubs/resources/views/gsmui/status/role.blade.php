@props([
    'role' => 'user',
    'size' => 'md',
])

@php
$roles = [
    'admin' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800',
    'moderator' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-400 dark:border-purple-800',
    'editor' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
    'user' => 'bg-zinc-100 text-zinc-800 border-zinc-200 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-700',
    'guest' => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700',
    'owner' => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
];

$sizes = [
    'sm' => 'px-1.5 py-0.5 text-[10px]',
    'md' => 'px-2 py-0.5 text-xs',
    'lg' => 'px-2.5 py-1 text-sm',
];

$colorClass = $roles[$role] ?? $roles['user'];
$sizeClass = $sizes[$size] ?? 'px-2 py-0.5 text-xs';
@endphp

<span {{ $attributes->class(['inline-flex items-center rounded-full border font-medium capitalize', $sizeClass, $colorClass]) }}>
    {{ $role }}
</span>
