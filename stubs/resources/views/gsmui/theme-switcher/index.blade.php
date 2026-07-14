@props([
    'size' => 'md',
    'persist' => true,
    'showLabel' => false,
    'label' => null,
])

@php
$sizes = [
    'sm' => [
        'wrapper' => 'h-8 w-14',
        'thumb' => 'h-6 w-6',
        'icon' => 'h-3.5 w-3.5',
        'translate' => 'translate-x-6',
        'text' => 'text-xs',
    ],
    'md' => [
        'wrapper' => 'h-10 w-[3.25rem]',
        'thumb' => 'h-8 w-8',
        'icon' => 'h-4 w-4',
        'translate' => 'translate-x-[1.125rem]',
        'text' => 'text-sm',
    ],
    'lg' => [
        'wrapper' => 'h-12 w-16',
        'thumb' => 'h-10 w-10',
        'icon' => 'h-5 w-5',
        'translate' => 'translate-x-[1.375rem]',
        'text' => 'text-base',
    ],
];

$sizeData = $sizes[$size] ?? $sizes['md'];
@endphp

<div 
    {{ $attributes->class(['inline-flex items-center gap-2']) }}
    x-data="themeSwitcher({{ $persist ? 'true' : 'false' }})"
    x-init="init()"
>
    @if($showLabel || $label)
    <span class="{{ $sizeData['text'] }} font-medium text-zinc-700 dark:text-zinc-300" x-text="currentLabel">
        {{ $label ?? 'Theme' }}
    </span>
    @endif

    <button 
        type="button"
        @click="toggle()"
        :class="isDark ? 'bg-zinc-700' : 'bg-zinc-200'"
        class="relative inline-flex {{ $sizeData['wrapper'] }} shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-zinc-500/30 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-zinc-900"
        role="switch"
        :aria-checked="isDark.toString()"
        aria-label="Toggle dark mode"
        x-cloak
    >
        <!-- Track Background - Sun/Moon Gradient -->
        <span 
            class="absolute inset-0 rounded-full transition-opacity duration-300"
            :class="isDark ? 'opacity-100' : 'opacity-0'"
            style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);"
        ></span>
        <span 
            class="absolute inset-0 rounded-full transition-opacity duration-300"
            :class="isDark ? 'opacity-0' : 'opacity-100'"
            style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);"
        ></span>

        <!-- Thumb -->
        <span 
            class="pointer-events-none relative inline-block {{ $sizeData['thumb'] }} rounded-full bg-white shadow-lg ring-0 transition-all duration-300 ease-in-out flex items-center justify-center"
            :class="isDark ? '{{ $sizeData['translate'] }}' : 'translate-x-0'"
        >
            <!-- Sun Icon -->
            <svg 
                class="{{ $sizeData['icon'] }} text-amber-500 transition-all duration-300"
                :class="isDark ? 'opacity-0 rotate-90 scale-0' : 'opacity-100 rotate-0 scale-100'"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor" 
                stroke-width="2"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            
            <!-- Moon Icon -->
            <svg 
                class="{{ $sizeData['icon'] }} text-indigo-400 absolute transition-all duration-300"
                :class="isDark ? 'opacity-100 rotate-0 scale-100' : 'opacity-0 -rotate-90 scale-0'"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor" 
                stroke-width="2"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </span>

        <!-- Stars (visible in dark mode) -->
        <template x-if="isDark">
            <div class="absolute inset-0 overflow-hidden rounded-full pointer-events-none">
                <span class="absolute top-1 left-1 w-1 h-1 bg-white rounded-full animate-pulse" style="animation-delay: 0s;"></span>
                <span class="absolute top-3 left-3 w-0.5 h-0.5 bg-white/80 rounded-full animate-pulse" style="animation-delay: 0.5s;"></span>
                <span class="absolute bottom-2 left-2 w-0.5 h-0.5 bg-white/60 rounded-full animate-pulse" style="animation-delay: 1s;"></span>
            </div>
        </template>
    </button>
</div>

<script>
function themeSwitcher(persist = true) {
    return {
        isDark: false,
        currentLabel: '{{ $label ?? "Theme" }}',
        
        init() {
            // Check for saved preference
            const savedTheme = localStorage.getItem('gsmui-theme');
            
            if (savedTheme) {
                this.isDark = savedTheme === 'dark';
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                // Check system preference
                this.isDark = true;
            }
            
            // Apply theme
            this.applyTheme();
            
            // Listen for system preference changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('gsmui-theme')) {
                    this.isDark = e.matches;
                    this.applyTheme();
                }
            });
        },
        
        toggle() {
            this.isDark = !this.isDark;
            this.applyTheme();
            
            // Save preference
            if (persist) {
                localStorage.setItem('gsmui-theme', this.isDark ? 'dark' : 'light');
            }
        },
        
        applyTheme() {
            const html = document.documentElement;
            
            if (this.isDark) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
            
            // Update current label
            this.currentLabel = this.isDark ? '🌙 Dark' : '☀️ Light';
        }
    }
}
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
    
    @keyframes twinkle {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
</style>
