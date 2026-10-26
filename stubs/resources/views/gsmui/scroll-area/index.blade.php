@props([
    'scrollbars' => 'auto',
    'type' => 'scroll',
    'class' => '',
    'style' => '',
])

<?php
$scrollbarsClass = match($scrollbars) {
    'auto' => '',
    'always' => 'scrollbar-always',
    'hover' => 'scrollbar-hover',
    'never' => 'scrollbar-never',
    default => '',
};

$typeClass = match($type) {
    'scroll' => 'overflow-auto',
    'auto' => 'overflow-auto',
    'overlay' => 'overflow-auto scrollbar-overlay',
    default => 'overflow-auto',
};
?>

<div 
    class="relative {{ $typeClass }} {{ $scrollbarsClass }} {{ $class }}"
    style="{{ $style }}"
    role="region"
    aria-label="Scrollable content"
    tabindex="0"
>
    <div class="scroll-content">
        {{ $slot }}
    </div>
</div>

<style>
    .scrollbar-always ::-webkit-scrollbar { display: block; }
    .scrollbar-hover ::-webkit-scrollbar { display: none; }
    .scrollbar-hover:hover ::-webkit-scrollbar { display: block; }
    .scrollbar-never ::-webkit-scrollbar { display: none; }
    
    .scrollbar-overlay ::-webkit-scrollbar { 
        width: 8px; 
        height: 8px; 
    }
    .scrollbar-overlay ::-webkit-scrollbar-track { 
        background: transparent; 
    }
    .scrollbar-overlay ::-webkit-scrollbar-thumb { 
        background: var(--gsmui-border-primary); 
        border-radius: 4px; 
    }
    .scrollbar-overlay ::-webkit-scrollbar-thumb:hover { 
        background: var(--gsmui-muted-primary); 
    }
    
    @media (prefers-reduced-motion: reduce) {
        .scroll-content { scroll-behavior: auto; }
    }
</style>