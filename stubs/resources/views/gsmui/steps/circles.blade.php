@props([
    'steps' => [],
    'current' => 1,
    'color' => 'blue',
    'showLabels' => true,
])

@php
$colors = [
    'blue' => ['active' => 'border-blue-500 bg-blue-50', 'text' => 'text-blue-600 dark:text-blue-400'],
    'green' => ['active' => 'border-green-500 bg-green-50', 'text' => 'text-green-600 dark:text-green-400'],
    'purple' => ['active' => 'border-purple-500 bg-purple-50', 'text' => 'text-purple-600 dark:text-purple-400'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['flex items-center gap-6']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isActive = $stepNumber === $current;
            $isCompleted = $stepNumber < $current;
            $size = 40 + ($stepNumber * 8);
        @endphp
        
        <div class="flex flex-col items-center">
            {{-- Concentric circles --}}
            <div class="relative flex items-center justify-center" style="width: {{ $size }}px; height: {{ $size }}px;">
                @for($i = 3; $i >= 1; $i--)
                    <div 
                        class="absolute rounded-full border-2 transition-all duration-500
                        {{ $isActive ? $colorSet['active'] . ' border-opacity-100' : ($isCompleted ? 'border-current ' . $colorSet['text'] . ' border-opacity-75' : 'border-zinc-200 dark:border-zinc-700') }}"
                        style="width: {{ $size - ($i * 8) }}px; height: {{ $size - ($i * 8) }}px;
                        {{ $isActive ? 'border-width: ' . ($i + 1) . 'px;' : '' }}"
                    ></div>
                @endfor
                
                {{-- Center content --}}
                <div class="relative z-10 w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                    {{ $isActive ? $colorSet['active'] . ' ' . $colorSet['text'] : ($isCompleted ? $colorSet['text'] : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500') }}">
                    @if($isCompleted)
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>
            </div>
            
            @if($showLabels)
                <div class="mt-3 text-center">
                    <span class="text-xs font-medium {{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                        {{ $step['title'] ?? 'Step ' . $stepNumber }}
                    </span>
                </div>
            @endif
        </div>
    @endforeach
</div>
