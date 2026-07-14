@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'separator' => 'chevron',
])

@php
$colors = [
    'blue' => 'text-blue-600 dark:text-blue-400',
    'green' => 'text-green-600 dark:text-green-400',
    'purple' => 'text-purple-600 dark:text-purple-400',
];
$colorClass = $colors[$color] ?? 'text-blue-600 dark:text-blue-400';

$separators = [
    'chevron' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
    'slash' => '<span class="text-zinc-400 dark:text-zinc-500">/</span>',
    'dot' => '<span class="text-zinc-400 dark:text-zinc-500">·</span>',
    'arrow' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>',
];
$separatorHtml = $separators[$separator] ?? $separators['chevron'];
@endphp

<nav {{ $attributes->class(['flex items-center space-x-2 text-sm']) }} aria-label="Steps">
    <ol class="flex items-center space-x-2">
        @foreach($steps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isActive = $stepNumber === $current;
                $isCompleted = $stepNumber < $current;
                $isLast = $index === count($steps) - 1;
            @endphp
            
            <li class="flex items-center {{ $isLast ? '' : 'space-x-2' }}">
                <a 
                    href="{{ $step['url'] ?? '#' }}"
                    class="flex items-center gap-1.5 transition-colors duration-200 {{ $isActive ? $colorClass . ' font-semibold' : ($isCompleted ? 'text-zinc-700 dark:text-zinc-300 hover:' . $colorClass : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300') }}"
                    @if($isActive) aria-current="page" @endif
                >
                    @if($isCompleted)
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @endif
                    <span>{{ $step['title'] ?? 'Step ' . $stepNumber }}</span>
                </a>
                
                @if(!$isLast)
                    <span class="flex-shrink-0 text-zinc-400 dark:text-zinc-500">{!! $separatorHtml !!}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
