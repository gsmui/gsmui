@props([
    'label' => 'RECORD',
    'recording' => false,
])

<div {{ $attributes->class([
    'bg-zinc-900 rounded-lg border border-zinc-700 p-4 shadow-xl',
]) }}>
    {{-- VHS Label --}}
    <div class="bg-white dark:bg-zinc-100 rounded px-3 py-2 mb-3 text-center">
        <p class="text-sm font-bold text-zinc-800 uppercase tracking-widest">{{ $label }}</p>
    </div>
    
    {{-- Tape window --}}
    <div class="bg-zinc-800 rounded border border-zinc-600 p-2 mb-3">
        <div class="flex justify-between items-center">
            <div class="w-8 h-8 rounded-full bg-zinc-700 border-2 border-zinc-500"></div>
            <div class="flex-1 mx-2 h-1 bg-zinc-600 rounded"></div>
            <div class="w-8 h-8 rounded-full bg-zinc-700 border-2 border-zinc-500"></div>
        </div>
    </div>
    
    {{-- Recording indicator --}}
    @if($recording)
    <div class="flex items-center justify-center gap-2">
        <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
        <span class="text-xs text-red-500 font-bold">REC</span>
    </div>
    @endif
    
    {{-- Content --}}
    <div class="mt-3 bg-zinc-100 dark:bg-zinc-200 rounded overflow-hidden">
        {{ $slot }}
    </div>
</div>
