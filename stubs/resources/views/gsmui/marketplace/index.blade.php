@props([
    'items' => [],
    'categories' => [],
    'featured' => [],
    'class' => '',
])

<?php
$id = 'marketplace-' . uniqid();
$categories = $categories ?: ['All', 'Themes', 'Plugins', 'Components', 'Tools', 'Templates'];
$items = $items ?: [
    ['id' => 1, 'name' => 'Dark Admin', 'type' => 'theme', 'description' => 'Professional dark admin theme', 'price' => 29, 'rating' => 4.8, 'downloads' => 1520, 'author' => 'Gsmui', 'image' => ''],
    ['id' => 2, 'name' => 'Form Builder Pro', 'type' => 'plugin', 'description' => 'Advanced drag-drop form builder', 'price' => 49, 'rating' => 4.6, 'downloads' => 890, 'author' => 'Gsmui', 'image' => ''],
    ['id' => 3, 'name' => 'Charts Bundle', 'type' => 'component', 'description' => '20+ chart components', 'price' => 39, 'rating' => 4.9, 'downloads' => 2100, 'author' => 'Gsmui', 'image' => ''],
    ['id' => 4, 'name' => 'Starter Kit', 'type' => 'template', 'description' => 'Quick-start project template', 'price' => 0, 'rating' => 4.7, 'downloads' => 5400, 'author' => 'Gsmui', 'image' => ''],
];
$featured = $featured ?: [$items[2], $items[0]];
?>

<div 
    class="gsmui-marketplace {{ $class }}"
    x-data="gsmuiMarketplace({
        items: @js($items),
        categories: @js($categories),
        featured: @js($featured),
    })"
    id="{{ $id }}"
>
    <div class="space-y-8">
        <!-- Hero -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary/10 via-primary/5 to-zinc-100 dark:from-primary/20 dark:via-primary/10 dark:to-zinc-800 p-8 sm:p-12">
            <div class="relative z-10 max-w-2xl">
                <h1 class="text-3xl sm:text-4xl font-bold text-zinc-900 dark:text-white mb-3">Marketplace</h1>
                <p class="text-lg text-zinc-600 dark:text-zinc-400 mb-6">Discover themes, plugins, and components to extend your app.</p>
                <div class="relative max-w-md">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="search" x-model="search" class="w-full pl-12 pr-4 py-3 rounded-xl border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Search marketplace..." />
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="flex flex-wrap gap-2">
            <template x-for="cat in categories" :key="cat">
                <button @click="selectedCategory = cat; page = 1"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                    :class="selectedCategory === cat ? 'bg-primary text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
                    x-text="cat">
                </button>
            </template>
        </div>

        <!-- Featured -->
        <template x-if="featured.length > 0 && !search">
            <section>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">Featured</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="item in featured" :key="item.id">
                        <div class="relative overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-6 hover:shadow-lg transition-shadow group">
                            <div class="flex items-start gap-4">
                                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center flex-shrink-0 text-2xl font-bold text-primary" x-text="item.name[0]"></div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-zinc-900 dark:text-white" x-text="item.name"></h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2" x-text="item.description"></p>
                                    <div class="flex items-center gap-3 mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <span x-text="item.rating"></span>
                                        </span>
                                        <span x-text="item.downloads.toLocaleString() + ' downloads'"></span>
                                        <span x-text="'by ' + item.author"></span>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <div class="text-lg font-bold text-zinc-900 dark:text-white" x-text="item.price === 0 ? 'Free' : '$' + item.price"></div>
                                    <button @click="install(item)" class="mt-2 px-4 py-1.5 bg-primary text-white text-sm rounded-lg hover:bg-primary/90 transition-colors" x-text="installedItems.includes(item.id) ? 'Installed' : 'Install'"></button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </section>
        </template>

        <!-- All Items -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                    <span x-text="selectedCategory"></span>
                    <span class="text-sm font-normal text-zinc-500 dark:text-zinc-400 ml-2" x-text="'(' + filteredItems.length + ' items)'"></span>
                </h2>
                <select x-model="sortBy" class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800">
                    <option value="popular">Most Popular</option>
                    <option value="rating">Highest Rated</option>
                    <option value="newest">Newest</option>
                    <option value="price">Price: Low to High</option>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <template x-for="item in paginatedItems" :key="item.id">
                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden hover:shadow-md transition-shadow group">
                        <div class="h-40 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-700 dark:to-zinc-800 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-full bg-white dark:bg-zinc-700 shadow flex items-center justify-center text-2xl font-bold text-primary" x-text="item.name[0]"></div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-zinc-900 dark:text-white truncate" x-text="item.name"></h3>
                                    <span class="text-xs text-primary uppercase tracking-wide" x-text="item.type"></span>
                                </div>
                                <div class="text-sm font-bold text-zinc-900 dark:text-white flex-shrink-0" x-text="item.price === 0 ? 'Free' : '$' + item.price"></div>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2" x-text="item.description"></p>
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-zinc-100 dark:border-zinc-700">
                                <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span x-text="item.rating"></span>
                                    </span>
                                    <span x-text="item.downloads.toLocaleString()"></span>
                                </div>
                                <button @click="install(item)" 
                                    class="px-3 py-1 text-xs rounded-lg transition-colors"
                                    :class="installedItems.includes(item.id) ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-primary text-white hover:bg-primary/90'"
                                    x-text="installedItems.includes(item.id) ? '✓ Installed' : 'Install'">
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-center gap-2 mt-8" x-show="totalPages > 1">
                <button @click="page--" :disabled="page === 1" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg disabled:opacity-50 hover:bg-zinc-50 dark:hover:bg-zinc-700">Previous</button>
                <template x-for="p in totalPages" :key="p">
                    <button @click="page = p" class="px-3 py-2 text-sm rounded-lg transition-colors"
                        :class="page === p ? 'bg-primary text-white' : 'border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-700'"
                        x-text="p">
                    </button>
                </template>
                <button @click="page++" :disabled="page >= totalPages" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg disabled:opacity-50 hover:bg-zinc-50 dark:hover:bg-zinc-700">Next</button>
            </div>
        </section>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiMarketplace', (config) => ({
        items: config.items,
        categories: config.categories,
        featured: config.featured,
        search: '',
        selectedCategory: 'All',
        sortBy: 'popular',
        page: 1,
        perPage: 12,
        installedItems: [],

        get filteredItems() {
            let result = this.items;
            if (this.selectedCategory !== 'All') {
                result = result.filter(i => i.type.toLowerCase() === this.selectedCategory.toLowerCase().replace(/s$/, ''));
            }
            if (this.search) {
                const q = this.search.toLowerCase();
                result = result.filter(i => i.name.toLowerCase().includes(q) || i.description.toLowerCase().includes(q));
            }
            if (this.sortBy === 'popular') result.sort((a,b) => b.downloads - a.downloads);
            else if (this.sortBy === 'rating') result.sort((a,b) => b.rating - a.rating);
            else if (this.sortBy === 'price') result.sort((a,b) => a.price - b.price);
            return result;
        },

        get totalPages() {
            return Math.ceil(this.filteredItems.length / this.perPage);
        },

        get paginatedItems() {
            const start = (this.page - 1) * this.perPage;
            return this.filteredItems.slice(start, start + this.perPage);
        },

        install(item) {
            if (!this.installedItems.includes(item.id)) {
                this.installedItems.push(item.id);
                this.$dispatch('marketplace:installed', { item });
            }
        },
    }));
});
</script>
