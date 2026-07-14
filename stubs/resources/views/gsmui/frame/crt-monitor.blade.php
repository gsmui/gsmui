@props([
    'scanlines' => true,
    'flicker' => false,
])

<div class="bg-zinc-800 rounded-xl p-4 border-4 border-zinc-700 shadow-2xl">
    <div class="bg-zinc-900 rounded-lg overflow-hidden relative">
        {{-- CRT Screen --}}
        <div class="relative {{ $flicker ? 'animate-flicker' : '' }}">
            {{ $slot }}
        </div>
        
        {{-- Scanlines --}}
        @if($scanlines)
        <div class="absolute inset-0 pointer-events-none bg-repeating-linear-gradient-0 from-transparent via-black/5 to-transparent" 
             style="background-size: 100% 2px;"></div>
        @endif
        
        {{-- Screen curve effect --}}
        <div class="absolute inset-0 pointer-events-none bg-gradient-to-b from-black/10 via-transparent to-black/10 rounded-lg"></div>
    </div>
    
    {{-- Monitor base --}}
    <div class="mt-4 flex justify-center">
        <div class="w-16 h-2 bg-zinc-600 rounded-full"></div>
    </div>
</div>
