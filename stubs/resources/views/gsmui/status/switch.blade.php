@props([
    'label' => 'Toggle',
    'enabled' => false,
    'size' => 'md',
])

$heights = ['sm' => 'h-5 w-9', 'md' => 'h-6 w-11', 'lg' => 'h-7 w-14'];
$dotSizes = ['sm' => 'h-3.5 w-3.5', 'md' => 'h-4 w-4', 'lg' => 'h-5 w-5'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2 cursor-pointer']) }}>
    <span class="relative inline-flex {{ $heights[$size] ?? $heights['md'] }} rounded-full transition-colors {{ $enabled ? 'bg-green-500' : 'bg-zinc-300 dark:bg-zinc-600' }}">
        <span class="absolute top-0.5 left-0.5 {{ $dotSizes[$size] ?? $dotSizes['md'] }} rounded-full bg-white shadow transition-transform {{ $enabled ? 'translate-x-full' : '' }}"></span>
    </span>
    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
</div>
