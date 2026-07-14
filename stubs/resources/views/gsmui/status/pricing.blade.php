@props([
    'plan' => 'free',
    'size' => 'md',
])

@php
$plans = [
    'free' => [
        'label' => 'Free',
        'classes' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300',
    ],
    'starter' => [
        'label' => 'Starter',
        'classes' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    ],
    'pro' => [
        'label' => 'Pro',
        'classes' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
    ],
    'enterprise' => [
        'label' => 'Enterprise',
        'classes' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
    ],
    'business' => [
        'label' => 'Business',
        'classes' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    ],
];

$sizes = [
    'sm' => 'px-1.5 py-0.5 text-[10px]',
    'md' => 'px-2 py-0.5 text-xs',
    'lg' => 'px-2.5 py-1 text-sm',
];

$planData = $plans[$plan] ?? $plans['free'];
$sizeClass = $sizes[$size] ?? 'px-2 py-0.5 text-xs';
@endphp

<span {{ $attributes->class(['inline-flex items-center rounded-full font-semibold uppercase tracking-wider', $sizeClass, $planData['classes']]) }}>
    {{ $planData['label'] }}
</span>
