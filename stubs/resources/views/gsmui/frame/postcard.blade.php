@props([
    'stamp' => true,
    'postmark' => false,
])

<div {{ $attributes->class([
    'bg-amber-50 dark:bg-amber-950/30 rounded-lg shadow-lg overflow-hidden',
    'border border-amber-200 dark:border-amber-800',
]) }}>
    <div class="flex">
        {{-- Image side --}}
        <div class="flex-1 p-3">
            <div class="bg-zinc-200 dark:bg-zinc-700 rounded aspect-video overflow-hidden">
                {{ $slot }}
            </div>
        </div>
        
        {{-- Message side --}}
        <div class="flex-1 p-4 border-l border-amber-200 dark:border-amber-800">
            {{-- Stamp --}}
            @if($stamp)
            <div class="float-right w-12 h-12 bg-zinc-200 dark:bg-zinc-700 rounded border border-zinc-300 dark:border-zinc-600 flex items-center justify-center mb-2">
                <span class="text-xs">📮</span>
            </div>
            @endif
            
            {{-- Lines --}}
            <div class="space-y-3 mt-2">
                <div class="h-px bg-amber-300 dark:bg-amber-700"></div>
                <div class="h-px bg-amber-300 dark:bg-amber-700"></div>
                <div class="h-px bg-amber-300 dark:bg-amber-700"></div>
                <div class="h-px bg-amber-300 dark:bg-amber-700"></div>
            </div>
        </div>
    </div>
</div>
