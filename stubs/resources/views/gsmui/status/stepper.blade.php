@props([
    'steps' => [],
    'current' => 1,
    'size' => 'md',
])

@php
$stepColors = [
    'completed' => 'bg-green-500 text-white',
    'current' => 'bg-blue-500 text-white',
    'pending' => 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400',
];
@endphp

<div {{ $attributes->class(['flex items-center gap-2']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $status = $stepNumber < $current ? 'completed' : ($stepNumber === $current ? 'current' : 'pending');
        @endphp
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $stepColors[$status] }}">
                @if($status === 'completed')
                    ✓
                @else
                    {{ $stepNumber }}
                @endif
            </div>
            <span class="text-xs font-medium {{ $status === 'current' ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">{{ $step }}</span>
        </div>
        @if(!$loop->last)
            <div class="w-6 h-0.5 {{ $status === 'completed' ? 'bg-green-500' : 'bg-zinc-200 dark:bg-zinc-700' }}"></div>
        @endif
    @endforeach
</div>
