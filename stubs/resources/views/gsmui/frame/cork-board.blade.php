@props([
    'pins' => true,
    'frame' => true,
])

<div class="relative">
    @if($frame)
    {{-- Frame --}}
    <div class="absolute inset-0 bg-gradient-to-b from-amber-800 via-amber-700 to-amber-800 rounded-lg shadow-xl -m-1"></div>
    @endif
    
    <div {{ $attributes->class([
        'relative bg-amber-200 dark:bg-amber-900/50 rounded-lg p-4',
        $frame ? 'm-1' : '',
        'shadow-inner',
    ]) }}>
        {{-- Cork texture --}}
        <div class="absolute inset-0 opacity-20 pointer-events-none"
             style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23000000\" fill-opacity=\"0.1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        @if($pins)
        {{-- Push pins --}}
        <div class="absolute top-2 left-1/4 w-3 h-3 bg-red-500 rounded-full shadow-lg z-10"></div>
        <div class="absolute top-4 right-1/3 w-3 h-3 bg-blue-500 rounded-full shadow-lg z-10"></div>
        @endif
        
        <div class="relative z-10">
            {{ $slot }}
        </div>
    </div>
</div>
