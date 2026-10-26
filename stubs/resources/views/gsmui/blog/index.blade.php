@props([
    'posts' => [],
    'categories' => [],
    'tags' => [],
    'class' => '',
])

<?php
$id = 'blog-' . uniqid();
$posts = $posts ?: [
    ['id' => 1, 'title' => 'Getting Started with Gsmui', 'excerpt' => 'Learn how to build beautiful interfaces with Gsmui components.', 'category' => 'Tutorials', 'tags' => ['gsmui', 'introduction'], 'author' => 'Admin', 'date' => '2024-01-15', 'image' => '', 'reading_time' => 5],
    ['id' => 2, 'title' => 'Advanced Component Patterns', 'excerpt' => 'Deep dive into advanced patterns for building reusable components.', 'category' => 'Guides', 'tags' => ['components', 'patterns'], 'author' => 'Admin', 'date' => '2024-01-10', 'image' => '', 'reading_time' => 8],
    ['id' => 3, 'title' => 'State Management in Alpine.js', 'excerpt' => 'Managing complex state with Alpine.js reactive data stores.', 'category' => 'Tutorials', 'tags' => ['alpine', 'state'], 'author' => 'Editor', 'date' => '2024-01-05', 'image' => '', 'reading_time' => 6],
];
$categories = $categories ?: ['All', 'Tutorials', 'Guides', 'News', 'Releases'];
$tags = $tags ?: ['gsmui', 'introduction', 'components', 'patterns', 'alpine', 'state', 'laravel'];
?>

<div 
    class="gsmui-blog {{ $class }}"
    x-data="gsmuiBlog({
        posts: @js($posts),
        categories: @js($categories),
        tags: @js($tags),
    })"
    id="{{ $id }}"
>
    <div class="space-y-8">
        <!-- Hero -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary/5 to-zinc-100 dark:from-primary/10 dark:to-zinc-800 p-8 sm:p-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-zinc-900 dark:text-white mb-3">Blog</h1>
            <p class="text-lg text-zinc-600 dark:text-zinc-400 mb-6 max-w-xl">Articles, tutorials, and guides for building better interfaces.</p>
            <div class="relative max-w-md">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="search" x-model="search" class="w-full pl-12 pr-4 py-3 rounded-xl border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Search articles..." />
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

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="post in paginatedPosts" :key="post.id">
                <article class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden hover:shadow-md transition-shadow group">
                    <div class="h-44 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-700 dark:to-zinc-800 flex items-center justify-center overflow-hidden">
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="text-4xl font-bold text-primary/30" x-text="post.title[0]"></div>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400 mb-2">
                            <span class="px-2 py-0.5 bg-primary/10 text-primary rounded-full font-medium" x-text="post.category"></span>
                            <span x-text="post.reading_time + ' min read'"></span>
                        </div>
                        <h3 class="font-semibold text-zinc-900 dark:text-white group-hover:text-primary transition-colors" x-text="post.title"></h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2 line-clamp-2" x-text="post.excerpt"></p>
                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-700">
                            <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-xs font-medium text-primary" x-text="post.author[0]"></div>
                                <span x-text="post.author"></span>
                            </div>
                            <span class="text-xs text-zinc-400" x-text="post.date"></span>
                        </div>
                    </div>
                    <div class="px-5 pb-4 flex flex-wrap gap-1.5">
                        <template x-for="tag in post.tags" :key="tag">
                            <button @click.stop="search = tag; selectedCategory = 'All'" class="px-2 py-0.5 text-xs bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400 rounded-full hover:bg-primary/10 hover:text-primary transition-colors" x-text="'#' + tag"></button>
                        </template>
                    </div>
                </article>
            </template>
        </div>

        <!-- Empty State -->
        <template x-if="filteredPosts.length === 0">
            <div class="text-center py-16 text-zinc-500 dark:text-zinc-400">
                <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <p class="text-lg font-medium mb-1">No articles found</p>
                <p class="text-sm">Try adjusting your search or filter.</p>
            </div>
        </template>

        <!-- Pagination -->
        <div class="flex items-center justify-center gap-2" x-show="totalPages > 1">
            <button @click="page--" :disabled="page === 1" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg disabled:opacity-50 hover:bg-zinc-50 dark:hover:bg-zinc-700">← Previous</button>
            <template x-for="p in totalPages" :key="p">
                <button @click="page = p" class="px-3 py-2 text-sm rounded-lg transition-colors"
                    :class="page === p ? 'bg-primary text-white' : 'border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-700'"
                    x-text="p">
                </button>
            </template>
            <button @click="page++" :disabled="page >= totalPages" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg disabled:opacity-50 hover:bg-zinc-50 dark:hover:bg-zinc-700">Next →</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiBlog', (config) => ({
        posts: config.posts,
        categories: config.categories,
        tags: config.tags,
        search: '',
        selectedCategory: 'All',
        page: 1,
        perPage: 9,

        get filteredPosts() {
            let result = this.posts;
            if (this.selectedCategory !== 'All') {
                result = result.filter(p => p.category === this.selectedCategory);
            }
            if (this.search) {
                const q = this.search.toLowerCase();
                result = result.filter(p =>
                    p.title.toLowerCase().includes(q) ||
                    p.excerpt.toLowerCase().includes(q) ||
                    p.tags.some(t => t.toLowerCase().includes(q))
                );
            }
            return result;
        },

        get totalPages() {
            return Math.ceil(this.filteredPosts.length / this.perPage);
        },

        get paginatedPosts() {
            const start = (this.page - 1) * this.perPage;
            return this.filteredPosts.slice(start, start + this.perPage);
        },
    }));
});
</script>
