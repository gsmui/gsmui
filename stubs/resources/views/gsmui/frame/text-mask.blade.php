@props([
    'text' => 'FRAME',
    'fontSize' => 'text-9xl',
    'fontWeight' => 'font-black',
])

<div class="relative">
    {{ $slot }}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <span class="{{ $fontSize }} {{ $fontWeight }} text-transparent bg-clip-text bg-gradient-to-b from-white/0 to-white/20">
            {{ $text }}
        </span>
    </div>
</div>
