@blaze(fold: true)

@props([
    'value' => 'zinc-blue',
    'compact' => false,
    'label' => __('Theme'),
    'description' => __('Choose a color theme for the interface'),
    'showLabel' => true,
    'categories' => null,
    'searchable' => true,
    'id' => null,
])

@php
$themeData = include __DIR__ . '/../themes/themes.php';
$themes = $themeData['themes'];
$bases = $themeData['palettes']['bases'];
$accents = $themeData['palettes']['accents'];

$filteredThemes = $themes;
if ($categories) {
    $catArray = is_array($categories) ? $categories : explode(',', $categories ?? '');
    $filteredThemes = array_filter($themes, fn($t) => in_array($t['cat'], $catArray));
}

// Group themes by category for the dropdown
$grouped = [];
foreach ($filteredThemes as $t) {
    $grouped[$t['cat']][] = $t;
}

$selectorId = $id ?: 'theme-selector-' . str()->random(6);

$categoryLabels = [
    'classic' => 'Classic',
    'dark' => 'Dark',
    'vibrant' => 'Vibrant',
    'nature' => 'Nature',
    'retro' => 'Retro',
    'minimal' => 'Minimal',
    'special' => 'Special',
];
@endphp

<div
    x-data="{
        open: false,
        search: '',
        selected: '{{ $value }}',
        themes: {{ json_encode(array_map(fn($t) => ['id' => $t['id'], 'label' => $t['label'], 'cat' => $t['cat'], 'base' => $t['base'], 'accent' => $t['accent']], array_values($filteredThemes))) }},
        grouped: {{ json_encode(array_map(fn($g) => array_map(fn($t) => ['id' => $t['id'], 'label' => $t['label'], 'cat' => $t['cat'], 'base' => $t['base'], 'accent' => $t['accent']], $g), $grouped)) }},
        get filteredThemes() {
            if (!this.search) return this.grouped;
            const s = this.search.toLowerCase();
            const result = {};
            for (const [cat, items] of Object.entries(this.grouped)) {
                const filtered = items.filter(t => t.label.toLowerCase().includes(s) || t.id.includes(s));
                if (filtered.length) result[cat] = filtered;
            }
            return result;
        },
        select(id) {
            this.selected = id;
            this.open = false;
            this.search = '';
            this.$dispatch('gsmui-theme-select', { theme: id });
        },
        getPreviewColors(base, accent) {
            const b = {{ json_encode(array_map(fn($b) => ['id' => $b, 'light' => ['bg' => ($bases[$b]['light']['bg'] ?? '#ffffff'), 'bg-muted' => ($bases[$b]['light']['bg-muted'] ?? '#f4f4f5')]], array_keys($bases))) }};
            const a = {{ json_encode(array_map(fn($a) => ['id' => $a, 'light' => ['accent' => ($accents[$a]['light']['accent'] ?? '#2563eb')]], array_keys($accents))) }};
            const baseData = b.find(x => x.id === base);
            const accentData = a.find(x => x.id === accent);
            return {
                bg: baseData?.light?.bg || '#ffffff',
                muted: baseData?.light?.['bg-muted'] || '#f4f4f5',
                accent: accentData?.light?.accent || '#2563eb',
            };
        }
    }"
    x-id="['theme-selector']"
    class="relative"
    data-gsmui-customization-theme-selector
>
    {{-- Label --}}
    @if ($showLabel && $label)
        <label :for="$id('theme-selector')" class="block text-sm font-medium text-zinc-900 dark:text-white mb-1.5">
            {{ $label }}
        </label>
        @if ($description)
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-2">{{ $description }}</p>
        @endif
    @endif

    {{-- Trigger button --}}
    <button
        type="button"
        :id="$id('theme-selector')"
        @click="open = !open"
        @keydown.escape="open = false"
        :class="open ? 'ring-2 ring-(--color-accent, #3b82f6) border-transparent' : 'border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600'"
        class="flex items-center gap-3 w-full px-3 py-2 text-sm rounded-lg border bg-white dark:bg-zinc-900 transition-all duration-150"
        aria-haspopup="listbox"
        :aria-expanded="open"
    >
        {{-- Color preview --}}
        <template x-for="t in themes" :key="t.id">
            <template x-if="t.id === selected">
                <span class="flex items-center gap-2 shrink-0">
                    <span class="size-4 rounded-md border border-zinc-200 dark:border-zinc-700" :style="'background:' + getPreviewColors(t.base, t.accent).accent"></span>
                    <span class="size-3 rounded border border-zinc-200 dark:border-zinc-700" :style="'background:' + getPreviewColors(t.base, t.accent).bg"></span>
                </span>
            </template>
        </template>

        <span class="flex-1 text-left text-zinc-900 dark:text-white truncate" x-text="themes.find(t => t.id === selected)?.label || selected"></span>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 text-zinc-400 shrink-0" :class="open ? 'rotate-180' : ''">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    {{-- Dropdown --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        @click.away="open = false"
        class="absolute z-50 mt-1 w-full rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-xl shadow-zinc-200/20 dark:shadow-black/20 max-h-80 overflow-hidden flex flex-col"
        role="listbox"
    >
        {{-- Search --}}
        @if ($searchable)
            <div class="p-2 border-b border-zinc-200 dark:border-zinc-700">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute left-2.5 top-1/2 -translate-y-1/2 size-3.5 text-zinc-400 pointer-events-none">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                    <input
                        type="text"
                        x-model="search"
                        placeholder="Search themes..."
                        class="w-full h-8 pl-8 pr-2 text-xs rounded-md bg-zinc-100 dark:bg-zinc-700 border-0 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-(--color-accent)"
                    />
                </div>
            </div>
        @endif

        {{-- Theme list grouped by category --}}
        <div class="overflow-y-auto flex-1 p-1.5 space-y-1">
            <template x-for="(items, cat) in filteredThemes" :key="cat">
                <div>
                    <div class="px-2 py-1 text-[10px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500" x-text="cat.charAt(0).toUpperCase() + cat.slice(1)"></div>
                    <template x-for="t in items" :key="t.id">
                        <button
                            type="button"
                            @click="select(t.id)"
                            :class="selected === t.id ? 'bg-(--color-accent)/10 text-(--color-accent) dark:bg-(--color-accent)/20' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700/50'"
                            class="flex items-center gap-2.5 w-full px-2 py-1.5 text-xs rounded-lg transition-colors duration-100"
                            role="option"
                            :aria-selected="selected === t.id"
                        >
                            <span class="size-3.5 rounded border border-zinc-200 dark:border-zinc-700 shrink-0" :style="'background:' + getPreviewColors(t.base, t.accent).accent"></span>
                            <span class="flex-1 text-left truncate" x-text="t.label"></span>
                            <span class="text-[10px] text-zinc-400 dark:text-zinc-500 font-mono" x-text="t.id"></span>
                            <svg x-show="selected === t.id" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5 shrink-0">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </template>
                </div>
            </template>

            {{-- Empty state --}}
            <div x-show="Object.keys(filteredThemes).length === 0" class="text-center py-6">
                <p class="text-xs text-zinc-400 dark:text-zinc-500">No themes found</p>
            </div>
        </div>
    </div>
</div>
