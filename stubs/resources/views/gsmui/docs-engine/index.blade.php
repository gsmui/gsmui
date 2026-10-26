@props([
    'pages' => [],
    'currentPage' => null,
    'version' => '1.0',
    'searchable' => true,
    'class' => '',
])

<?php
$id = 'docs-engine-' . uniqid();
$pages = $pages ?: [
    ['id' => 'getting-started', 'title' => 'Getting Started', 'icon' => 'rocket-launch', 'children' => [
        ['id' => 'installation', 'title' => 'Installation'],
        ['id' => 'configuration', 'title' => 'Configuration'],
        ['id' => 'quickstart', 'title' => 'Quick Start'],
    ]],
    ['id' => 'components', 'title' => 'Components', 'icon' => 'puzzle-piece', 'children' => [
        ['id' => 'button', 'title' => 'Button'],
        ['id' => 'input', 'title' => 'Input'],
        ['id' => 'modal', 'title' => 'Modal'],
        ['id' => 'table', 'title' => 'Table'],
    ]],
    ['id' => 'advanced', 'title' => 'Advanced', 'icon' => 'beaker', 'children' => [
        ['id' => 'customization', 'title' => 'Customization'],
        ['id' => 'api', 'title' => 'API Reference'],
    ]],
];
?>

<div 
    class="gsmui-docs-engine {{ $class }}"
    x-data="gsmuiDocsEngine({
        pages: @js($pages),
        currentPageId: '{{ $currentPage ?? ($pages[0]['id'] ?? '') }}',
        version: '{{ $version }}',
        searchable: @js($searchable),
    })"
    id="{{ $id }}"
>
    <div class="flex h-full bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 lg:w-72 border-r border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900/50 flex flex-col overflow-hidden flex-shrink-0">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Documentation</h2>
                    <span class="text-xs px-2 py-0.5 bg-zinc-200 dark:bg-zinc-700 rounded text-zinc-600 dark:text-zinc-400" x-text="'v' + version"></span>
                </div>
                <template x-if="searchable">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="search" x-model="search" class="w-full pl-9 pr-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Search docs..." />
                    </div>
                </template>
            </div>

            <nav class="flex-1 overflow-y-auto p-3 space-y-1">
                <template x-for="section in filteredPages" :key="section.id">
                    <div class="mb-2">
                        <button @click="toggleSection(section)" class="flex items-center gap-2 w-full px-2 py-1.5 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': expandedSections.includes(section.id) }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <span x-text="section.title"></span>
                        </button>
                        <div class="ml-4 mt-1 space-y-0.5" x-show="expandedSections.includes(section.id)">
                            <template x-for="child in section.children" :key="child.id">
                                <button @click="navigate(child.id)" class="block w-full text-left px-3 py-1.5 text-sm rounded-lg transition-colors"
                                    :class="currentPageId === child.id ? 'bg-primary/10 text-primary font-medium' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-zinc-800'">
                                    <span x-text="child.title"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </nav>

            <div class="p-3 border-t border-zinc-200 dark:border-zinc-700">
                <a href="#" class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-primary transition-colors">Report an issue →</a>
            </div>
        </aside>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6 lg:p-10">
            <template x-if="currentPage">
                <article>
                    <header class="mb-8">
                        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white" x-text="currentPage.title"></h1>
                        <p class="mt-2 text-zinc-500 dark:text-zinc-400">Learn how to use and configure the <strong x-text="currentPage.title"></strong> feature.</p>
                    </header>

                    <div class="prose prose-zinc dark:prose-invert max-w-none">
                        <p>This is the documentation page for <strong x-text="currentPage.title"></strong>. Replace this content with your actual documentation written in markdown or HTML.</p>

                        <h2>Installation</h2>
                        <pre class="bg-zinc-900 text-green-400 p-4 rounded-lg overflow-x-auto text-sm"><code>composer require vendor/package</code></pre>

                        <h2>Basic Usage</h2>
                        <pre class="bg-zinc-900 text-green-400 p-4 rounded-lg overflow-x-auto text-sm"><code>&lt;x-gsmui:{{ currentPage.title.toLowerCase().replace(/\s+/g, '-') }} /&gt;</code></pre>

                        <h2>Props</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse">
                                <thead><tr class="border-b border-zinc-200 dark:border-zinc-700"><th class="text-left py-2 px-3 text-sm font-medium">Prop</th><th class="text-left py-2 px-3 text-sm font-medium">Type</th><th class="text-left py-2 px-3 text-sm font-medium">Default</th><th class="text-left py-2 px-3 text-sm font-medium">Description</th></tr></thead>
                                <tbody>
                                    <tr class="border-b border-zinc-200 dark:border-zinc-700"><td class="py-2 px-3 text-sm">class</td><td class="py-2 px-3 text-sm font-mono text-xs">string</td><td class="py-2 px-3 text-sm font-mono text-xs">''</td><td class="py-2 px-3 text-sm">Additional CSS classes</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-12 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                        <button @click="previousPage()" x-show="previousPageId" class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-primary transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            <span x-text="getPageTitle(previousPageId)"></span>
                        </button>
                        <button @click="nextPage()" x-show="nextPageId" class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-primary transition-colors ml-auto">
                            <span x-text="getPageTitle(nextPageId)"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </article>
            </template>

            <template x-if="!currentPage">
                <div class="flex items-center justify-center h-full text-zinc-400 dark:text-zinc-600">
                    <p>Select a page from the sidebar</p>
                </div>
            </template>
        </main>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiDocsEngine', (config) => ({
        pages: config.pages,
        currentPageId: config.currentPageId,
        version: config.version,
        searchable: config.searchable,

        search: '',
        expandedSections: [],

        init() {
            this.pages.forEach(s => {
                if (s.children.some(c => c.id === this.currentPageId)) {
                    if (!this.expandedSections.includes(s.id)) this.expandedSections.push(s.id);
                }
            });
            this.expandedSections = this.pages.map(s => s.id);
        },

        get filteredPages() {
            if (!this.search) return this.pages;
            const q = this.search.toLowerCase();
            return this.pages.map(section => ({
                ...section,
                children: section.children.filter(c => c.title.toLowerCase().includes(q))
            })).filter(s => s.children.length > 0);
        },

        get currentPage() {
            for (const section of this.pages) {
                const found = section.children.find(c => c.id === this.currentPageId);
                if (found) return found;
            }
            return this.pages[0]?.children[0] || null;
        },

        get allPages() {
            return this.pages.flatMap(s => s.children);
        },

        get currentIndex() {
            return this.allPages.findIndex(p => p.id === this.currentPageId);
        },

        get previousPageId() {
            const idx = this.currentIndex;
            return idx > 0 ? this.allPages[idx - 1].id : null;
        },

        get nextPageId() {
            const idx = this.currentIndex;
            return idx < this.allPages.length - 1 ? this.allPages[idx + 1].id : null;
        },

        getPageTitle(id) {
            const page = this.allPages.find(p => p.id === id);
            return page ? page.title : '';
        },

        toggleSection(section) {
            const idx = this.expandedSections.indexOf(section.id);
            if (idx >= 0) this.expandedSections.splice(idx, 1);
            else this.expandedSections.push(section.id);
        },

        navigate(pageId) {
            this.currentPageId = pageId;
            const section = this.pages.find(s => s.children.some(c => c.id === pageId));
            if (section && !this.expandedSections.includes(section.id)) {
                this.expandedSections.push(section.id);
            }
        },

        previousPage() {
            if (this.previousPageId) this.navigate(this.previousPageId);
        },

        nextPage() {
            if (this.nextPageId) this.navigate(this.nextPageId);
        },
    }));
});
</script>

<style>
.gsmui-docs-engine .prose h2 {
    @apply text-xl font-semibold text-zinc-900 dark:text-white mt-8 mb-4;
}
.gsmui-docs-engine .prose h3 {
    @apply text-lg font-semibold text-zinc-900 dark:text-white mt-6 mb-3;
}
.gsmui-docs-engine .prose p {
    @apply text-zinc-600 dark:text-zinc-400 leading-relaxed mb-4;
}
.gsmui-docs-engine .prose code {
    @apply text-sm;
}
</style>
