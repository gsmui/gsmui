@blaze(fold: true, unsafe: ['previewCss'])

@php
$themeData = include __DIR__ . '/themes.php';
$themes = $themeData['themes'];
$bases = $themeData['palettes']['bases'];
$accents = $themeData['palettes']['accents'];

// Group themes by category
$categories = [];
foreach ($themes as $t) {
    $cat = $t['cat'];
    if (!isset($categories[$cat])) {
        $categories[$cat] = [];
    }
    $categories[$cat][] = $t;
}

// Generate a mini preview CSS for each theme (just accent + base colors)
function getThemePreviewCss($theme, $bases, $accents) {
    $base = $bases[$theme['base']] ?? $bases['zinc'];
    $accent = $accents[$theme['accent']] ?? $accents['blue'];
    
    $bg = $base['light']['bg'];
    $surface = $base['light']['bg-surface'];
    $text = $base['light']['text'];
    $border = $base['light']['border'];
    $accentColor = $accent['light']['accent'];
    
    return "background:{$bg};border-color:{$border};--preview-accent:{$accentColor};--preview-text:{$text};--preview-surface:{$surface}";
}

$categoryMeta = [
    'classic' => ['label' => 'Classic', 'icon' => 'star', 'desc' => 'Base + accent combinations for everyday use'],
    'dark' => ['label' => 'Dark', 'icon' => 'moon', 'desc' => 'Dark-first themes with rich contrast'],
    'vibrant' => ['label' => 'Vibrant', 'icon' => 'sparkles', 'desc' => 'Bold and saturated color palettes'],
    'nature' => ['label' => 'Nature', 'icon' => 'leaf', 'desc' => 'Earthy tones inspired by the natural world'],
    'retro' => ['label' => 'Retro', 'icon' => 'clock', 'desc' => 'Nostalgic vintage-inspired colorways'],
    'minimal' => ['label' => 'Minimal', 'icon' => 'adjustments-horizontal', 'desc' => 'Clean, understated color schemes'],
    'special' => ['label' => 'Special', 'icon' => 'beaker', 'desc' => 'Curated themes from popular design systems'],
];
@endphp

<div class="min-h-screen" data-gsmui-theme-demo x-data="{ activeTheme: 'zinc-blue', search: '', cat: 'all' }">
    {{-- Apply the selected theme --}}
    <gsmui:theme :theme="activeTheme" />
    {{-- Header --}}
    <div class="sticky top-0 z-40 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-xl border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Themes</h1>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ count($themes) }} themes available</p>
                </div>

                {{-- Search --}}
                <div class="relative flex-1 max-w-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-zinc-400 dark:text-zinc-500 pointer-events-none">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                    <input
                        type="search"
                        x-model="search"
                        placeholder="Search themes..."
                        class="w-full h-9 pl-9 pr-3 text-sm rounded-lg bg-zinc-100 dark:bg-zinc-800 border-0 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-(--color-accent)"
                    />
                </div>

                {{-- Active theme indicator --}}
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-xs font-medium">
                    <span class="text-zinc-500 dark:text-zinc-400">Active:</span>
                    <span class="text-zinc-900 dark:text-white" x-text="activeTheme.split('-').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ')"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Category tabs --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-6 pb-2 overflow-x-auto">
        <div class="flex gap-2">
            <button
                @click="cat = 'all'"
                :class="cat === 'all' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 border border-zinc-200 dark:border-zinc-800'"
                class="shrink-0 px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-150"
            >
                All Themes
                <span class="ml-1 opacity-60">({{ count($themes) }})</span>
            </button>

            @foreach ($categories as $catKey => $catThemes)
                @php $meta = $categoryMeta[$catKey] ?? ['label' => ucfirst($catKey), 'icon' => 'folder', 'desc' => '']; @endphp
                <button
                    @click="cat = '{{ $catKey }}'"
                    :class="cat === '{{ $catKey }}' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 border border-zinc-200 dark:border-zinc-800'"
                    class="shrink-0 px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-150"
                >
                    {{ $meta['label'] }}
                    <span class="ml-1 opacity-60">({{ count($catThemes) }})</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Theme grid --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
            @foreach ($themes as $t)
                @php
                    $base = $bases[$t['base']] ?? $bases['zinc'];
                    $accent = $accents[$t['accent']] ?? $accents['blue'];
                    $previewBg = $base['light']['bg'];
                    $previewAccent = $accent['light']['accent'];
                    $previewBorder = $base['light']['border'];
                    $previewText = $base['light']['text-muted'];
                    $previewSurface = $base['light']['bg-muted'];
                @endphp

                <div
                    x-data="{ id: '{{ $t['id'] }}', name: '{{ $t['label'] }}', cat: '{{ $t['cat'] }}' }"
                    x-show="cat === 'all' || cat === '{{ $t['cat'] }}'"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    :class="activeTheme === id ? 'ring-2 ring-offset-2 ring-zinc-400 dark:ring-zinc-500' : 'hover:ring-1 hover:ring-zinc-300 dark:hover:ring-zinc-700'"
                    class="relative rounded-xl border bg-white dark:bg-zinc-900 overflow-hidden cursor-pointer transition-all duration-150 group"
                    style="border-color: {{ $previewBorder }}"
                    @click="activeTheme = id; $dispatch('gsmui-theme-select', { theme: id })"
                >
                    {{-- Preview bar --}}
                    <div class="h-12 sm:h-14 flex items-end p-2 gap-1" style="background: {{ $previewBg }}">
                        <span class="w-5 h-5 rounded-md" style="background: {{ $previewAccent }}"></span>
                        <span class="w-5 h-5 rounded-md opacity-30" style="background: {{ $previewAccent }}"></span>
                        <span class="w-5 h-5 rounded-md opacity-15" style="background: {{ $previewAccent }}"></span>
                    </div>

                    {{-- Details --}}
                    <div class="p-2.5">
                        <p class="text-xs font-semibold text-zinc-900 dark:text-white truncate">{{ $t['label'] }}</p>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="text-[10px] font-mono text-zinc-400 dark:text-zinc-500 truncate">{{ $t['id'] }}</span>
                            <span class="size-1.5 rounded-full" style="background: {{ $previewAccent }}"></span>
                        </div>
                    </div>

                    {{-- Active indicator --}}
                    <div
                        x-show="activeTheme === id"
                        x-cloak
                        class="absolute top-1.5 right-1.5 size-4 rounded-full flex items-center justify-center"
                        style="background: {{ $previewAccent }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-2.5 text-white">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Empty state --}}
        <div
            x-show="cat !== 'all' && $el.parentElement.querySelectorAll('[x-show]:not([x-show=\\'false\\'])').length === 0"
            x-cloak
            class="text-center py-16"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-10 mx-auto text-zinc-300 dark:text-zinc-700 mb-3">
                <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0z" />
            </svg>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">No themes match your search</p>
        </div>
    </div>

    {{-- Apply button --}}
    <div class="sticky bottom-0 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-xl border-t border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Selected: <strong class="text-zinc-900 dark:text-white" x-text="activeTheme"></strong>
            </p>
            <div class="flex gap-2">
                <button
                    type="button"
                    @click="document.querySelector('[data-gsmui-theme-demo]').classList.remove('dark'); document.documentElement.classList.remove('dark')"
                    class="px-3 py-1.5 text-xs font-medium rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
                >
                    Light
                </button>
                <button
                    type="button"
                    @click="document.querySelector('[data-gsmui-theme-demo]').classList.add('dark'); document.documentElement.classList.add('dark')"
                    class="px-3 py-1.5 text-xs font-medium rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
                >
                    Dark
                </button>
                <button
                    type="button"
                    @click="$dispatch('gsmui-theme-apply', { theme: activeTheme })"
                    class="px-4 py-1.5 text-xs font-medium rounded-lg text-white transition-colors"
                    x-bind:style="'background-color: var(--color-accent, #2563eb)'"
                >
                    Apply Theme
                </button>
            </div>
        </div>
    </div>
</div>
