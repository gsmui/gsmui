@props([
    'pages' => [],
    'categories' => [],
    'tags' => [],
    'class' => '',
])

<?php
$id = 'cms-' . uniqid();
$pages = $pages ?: [
    ['id' => 1, 'title' => 'Welcome', 'status' => 'published', 'author' => 'Admin', 'updated_at' => '2024-01-15', 'category' => 'General'],
    ['id' => 2, 'title' => 'About Us', 'status' => 'published', 'author' => 'Admin', 'updated_at' => '2024-01-10', 'category' => 'Company'],
    ['id' => 3, 'title' => 'Features', 'status' => 'draft', 'author' => 'Editor', 'updated_at' => '2024-01-05', 'category' => 'Product'],
];
$categories = $categories ?: ['General', 'Company', 'Product', 'Blog'];
$tags = $tags ?: ['featured', 'new', 'popular', 'archived'];
?>

<div 
    class="gsmui-cms {{ $class }}"
    x-data="gsmuiCms({
        pages: @js($pages),
        categories: @js($categories),
        tags: @js($tags),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Content Manager</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage pages, posts, and content.</p>
            </div>
            <button @click="openEditor(null)" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Page
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="search" x-model="search" class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Search pages..." />
            </div>
            <select x-model="filterStatus" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                <option value="">All Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="archived">Archived</option>
            </select>
            <select x-model="filterCategory" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                <option value="">All Categories</option>
                <template x-for="cat in categories" :key="cat">
                    <option :value="cat" x-text="cat"></option>
                </template>
            </select>
        </div>

        <!-- Pages Table -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <table class="w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Title</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Category</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Author</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Updated</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <template x-for="page in filteredPages" :key="page.id">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="font-medium text-zinc-900 dark:text-white text-sm" x-text="page.title"></div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium capitalize"
                                    :class="{
                                        'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400': page.status === 'published',
                                        'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400': page.status === 'draft',
                                        'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400': page.status === 'archived'
                                    }"
                                    x-text="page.status">
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400" x-text="page.category"></td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400" x-text="page.author"></td>
                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400" x-text="page.updated_at"></td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button @click="openEditor(page)" class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-500 hover:text-primary transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button @click="deletePage(page)" class="p-1.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 text-zinc-500 hover:text-red-500 transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template x-if="filteredPages.length === 0">
                        <tr><td :colspan="6" class="px-4 py-12 text-center text-zinc-500 dark:text-zinc-400">No pages found</td></tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Page Editor Modal -->
        <template x-if="editorOpen">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/30" @click.self="editorOpen = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                    <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white" x-text="editingPage ? 'Edit Page' : 'New Page'"></h3>
                        <button @click="editorOpen = false" class="p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Title</label>
                            <input type="text" x-model="form.title" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Page title" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Category</label>
                                <select x-model="form.category" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                                    <template x-for="cat in categories" :key="cat">
                                        <option :value="cat" x-text="cat"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                                <select x-model="form.status" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Content</label>
                            <textarea x-model="form.content" rows="12" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Write your content here..."></textarea>
                        </div>
                    </div>
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                        <button @click="editorOpen = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700">Cancel</button>
                        <button @click="savePage()" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Save Page</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiCms', (config) => ({
        pages: config.pages,
        categories: config.categories,
        tags: config.tags,
        search: '',
        filterStatus: '',
        filterCategory: '',
        editorOpen: false,
        editingPage: null,
        form: { title: '', category: 'General', status: 'draft', content: '' },

        get filteredPages() {
            let result = this.pages;
            if (this.search) { const q = this.search.toLowerCase(); result = result.filter(p => p.title.toLowerCase().includes(q)); }
            if (this.filterStatus) result = result.filter(p => p.status === this.filterStatus);
            if (this.filterCategory) result = result.filter(p => p.category === this.filterCategory);
            return result;
        },

        openEditor(page) {
            this.editingPage = page;
            this.form = page ? { ...page } : { title: '', category: 'General', status: 'draft', content: '' };
            this.editorOpen = true;
        },

        savePage() {
            if (this.editingPage) {
                Object.assign(this.editingPage, this.form);
            } else {
                this.form.id = Date.now();
                this.form.author = 'Admin';
                this.form.updated_at = new Date().toISOString().slice(0, 10);
                this.pages.push({ ...this.form });
            }
            this.editorOpen = false;
        },

        deletePage(page) {
            if (confirm('Delete "' + page.title + '"?')) {
                this.pages = this.pages.filter(p => p.id !== page.id);
            }
        },
    }));
});
</script>
