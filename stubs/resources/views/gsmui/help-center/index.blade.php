@props([
    'articles' => [],
    'categories' => [],
    'class' => '',
])

<?php
$id = 'help-center-' . uniqid();
$categories = $categories ?: ['Getting Started', 'Account', 'Billing', 'Troubleshooting', 'API', 'Integrations'];
$articles = $articles ?: [
    ['id' => 1, 'title' => 'How to create your first project', 'category' => 'Getting Started', 'excerpt' => 'Learn how to set up and configure your first project.', 'views' => 2450, 'helpful' => 92],
    ['id' => 2, 'title' => 'Managing your account settings', 'category' => 'Account', 'excerpt' => 'Update your profile, password, and notification preferences.', 'views' => 1830, 'helpful' => 88],
    ['id' => 3, 'title' => 'Understanding billing and invoices', 'category' => 'Billing', 'excerpt' => 'Learn about pricing plans, payment methods, and invoices.', 'views' => 3210, 'helpful' => 95],
    ['id' => 4, 'title' => 'Troubleshooting common issues', 'category' => 'Troubleshooting', 'excerpt' => 'Solutions to frequently encountered problems.', 'views' => 4520, 'helpful' => 78],
    ['id' => 5, 'title' => 'API authentication guide', 'category' => 'API', 'excerpt' => 'How to authenticate and use the API.', 'views' => 1560, 'helpful' => 85],
];
?>

<div 
    class="gsmui-help-center {{ $class }}"
    x-data="gsmuiHelpCenter({
        articles: @js($articles),
        categories: @js($categories),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary/10 to-zinc-100 dark:from-primary/20 dark:to-zinc-800 p-8 sm:p-12 text-center">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2">How can we help?</h1>
            <div class="relative max-w-lg mx-auto mt-4">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="search" x-model="search" class="w-full pl-12 pr-4 py-3 rounded-xl border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Search articles..." />
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <template x-for="cat in categories" :key="cat">
                <button @click="selectedCategory = selectedCategory === cat ? '' : cat"
                    class="px-4 py-3 rounded-xl border text-sm font-medium transition-all"
                    :class="selectedCategory === cat ? 'border-primary bg-primary/10 text-primary' : 'border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:border-zinc-300 dark:hover:border-zinc-600'">
                    <span x-text="cat"></span>
                </button>
            </template>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="article in filteredArticles" :key="article.id">
                <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md transition-shadow cursor-pointer" @click="openArticle(article)">
                    <div class="text-xs font-medium text-primary mb-2" x-text="article.category"></div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white" x-text="article.title"></h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2" x-text="article.excerpt"></p>
                    <div class="flex items-center gap-3 mt-3 text-xs text-zinc-400">
                        <span x-text="article.views.toLocaleString() + ' views'"></span>
                        <span x-text="article.helpful + '% found helpful'"></span>
                    </div>
                </div>
            </template>
        </div>

        <template x-if="filteredArticles.length === 0">
            <div class="text-center py-16 text-zinc-500 dark:text-zinc-400">
                <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                <p>No articles found. Try a different search.</p>
            </div>
        </template>

        <div class="p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-center">
            <h3 class="font-semibold text-zinc-900 dark:text-white mb-2">Still need help?</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">Contact our support team and we'll get back to you.</p>
            <button class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">Contact Support</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiHelpCenter', (config) => ({
        articles: config.articles,
        categories: config.categories,
        search: '',
        selectedCategory: '',

        get filteredArticles() {
            let result = this.articles;
            if (this.selectedCategory) result = result.filter(a => a.category === this.selectedCategory);
            if (this.search) { const q = this.search.toLowerCase(); result = result.filter(a => a.title.toLowerCase().includes(q) || a.excerpt.toLowerCase().includes(q)); }
            return result;
        },

        openArticle(article) {
            this.$dispatch('help:article-opened', { article });
        },
    }));
});
</script>
