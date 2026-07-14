@props([
    'tray' => true,
    'markers' => false,
])

<div class="relative">
    {{-- Board --}}
    <div {{ $attributes->class([
        'bg-white dark:bg-zinc-800 rounded-lg shadow-xl border-4 border-zinc-300 dark:border-zinc-600',
        $tray ? 'pb-8' : '',
    ]) }}>
        {{ $slot }}
    </div>
    
    @if($tray)
    {{-- Marker tray --}}
    <div class="absolute bottom-0 left-0 right-0 h-6 bg-zinc-300 dark:bg-zinc-600 rounded-b-lg -mt-1"></div>
    @endif
    
    @if($markers)
    {{-- Markers --}}
    <div class="absolute bottom-1 left-1/2 -translate-x-1/2 flex gap-2">
        <div class="w-6 h-2 bg-red-500 rounded-full"></div>
        <div class="w-6 h-2 bg-blue-500 rounded-full"></div>
        <div class="w-6 h-2 bg-green-500 rounded-full"></div>
        <div class="w-6 h-2 bg-black rounded-full"></div>
    </div>
    @endif
</div>
