@props([
    'pages' => [],
    'redirects' => [],
    'class' => '',
])

<?php
$id = 'seo-manager-' . uniqid();
$pages = $pages ?: [
    ['id' => 1, 'path' => '/', 'title' => 'Home', 'meta_title' => 'My App - Home', 'meta_description' => 'Welcome to My App, the best platform for building interfaces.', 'og_image' => '', 'priority' => '1.0', 'index' => true],
    ['id' => 2, 'path' => '/pricing', 'title' => 'Pricing', 'meta_title' => 'Pricing - My App', 'meta_description' => 'View our flexible pricing plans.', 'og_image' => '', 'priority' => '0.8', 'index' => true],
    ['id' => 3, 'path' => '/about', 'title' => 'About', 'meta_title' => 'About Us - My App', 'meta_description' => 'Learn about our mission and team.', 'og_image' => '', 'priority' => '0.5', 'index' => true],
    ['id' => 4, 'path' => '/admin', 'title' => 'Admin', 'meta_title' => 'Admin - My App', 'meta_description' => '', 'og_image' => '', 'priority' => '0.1', 'index' => false],
];
$redirects = $redirects ?: [
    ['from' => '/old-page', 'to' => '/new-page', 'type' => 301, 'status' => 'active'],
    ['from' => '/temp-link', 'to' => '/permanent-link', 'type' => 302, 'status' => 'active'],
];
?>

<div 
    class="gsmui-seo-manager {{ $class }}"
    x-data="gsmuiSeoManager({
        pages: @js($pages),
        redirects: @js($redirects),
    })"
    id="{{ $id }}"
>
    <div x-data="{ tab: 'pages' }" class="space-y-6">
        <div class="flex items-center justify-between">
            <div><h2 class="text-xl font-semibold text-zinc-900 dark:text-white">SEO Manager</h2><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage meta tags, sitemap, and redirects.</p></div>
            <div class="flex items-center gap-2">
                <button @click="generateSitemap" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50">Generate Sitemap</button>
                <button @click="showAddRedirect = true" x-show="tab === 'redirects'" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ Add Redirect</button>
            </div>
        </div>

        <div class="flex gap-2">
            <button @click="tab = 'pages'" class="px-4 py-2 text-sm rounded-lg font-medium transition-colors" :class="tab === 'pages' ? 'bg-primary text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300'">Meta Tags</button>
            <button @click="tab = 'redirects'" class="px-4 py-2 text-sm rounded-lg font-medium transition-colors" :class="tab === 'redirects' ? 'bg-primary text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300'">Redirects</button>
            <button @click="tab = 'analytics'" class="px-4 py-2 text-sm rounded-lg font-medium transition-colors" :class="tab === 'analytics' ? 'bg-primary text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300'">Analytics</button>
        </div>

        <!-- Meta Tags -->
        <template x-if="tab === 'pages'">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <tr><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Page</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Meta Title</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider hidden lg:table-cell">Meta Description</th><th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Index</th><th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Priority</th></tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            <template x-for="page in pages" :key="page.id">
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-sm text-zinc-900 dark:text-white" x-text="page.title"></div>
                                        <code class="text-xs text-zinc-500" x-text="page.path"></code>
                                    </td>
                                    <td class="px-4 py-3"><input type="text" x-model="page.meta_title" class="w-full px-2 py-1 text-sm border border-transparent hover:border-zinc-300 focus:border-primary rounded bg-transparent focus:bg-white dark:focus:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" /></td>
                                    <td class="px-4 py-3 hidden lg:table-cell"><input type="text" x-model="page.meta_description" class="w-full px-2 py-1 text-sm border border-transparent hover:border-zinc-300 focus:border-primary rounded bg-transparent focus:bg-white dark:focus:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" /></td>
                                    <td class="px-4 py-3 text-center"><input type="checkbox" x-model="page.index" class="w-4 h-4 text-primary rounded border-zinc-300" /></td>
                                    <td class="px-4 py-3 text-right text-sm text-zinc-600 tabular-nums" x-text="page.priority"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>

        <!-- Redirects -->
        <template x-if="tab === 'redirects'">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                        <tr><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">From</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">To</th><th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Type</th><th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th><th class="text-right px-4 py-3"></th></tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        <template x-for="(r, i) in redirects" :key="i">
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3"><code class="text-sm font-mono text-zinc-800 dark:text-zinc-200" x-text="r.from"></code></td>
                                <td class="px-4 py-3"><code class="text-sm font-mono text-zinc-800 dark:text-zinc-200" x-text="r.to"></code></td>
                                <td class="px-4 py-3 text-center"><span class="text-xs px-2 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-700 text-zinc-600 font-mono" x-text="r.type"></span></td>
                                <td class="px-4 py-3 text-center"><span class="text-xs px-2 py-0.5 rounded-full capitalize" :class="r.status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-zinc-100 text-zinc-600'" x-text="r.status"></span></td>
                                <td class="px-4 py-3 text-right"><button @click="redirects.splice(i,1)" class="p-1 text-zinc-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <template x-if="redirects.length === 0"><div class="p-8 text-center text-zinc-500"><p>No redirects configured.</p></div></template>
            </div>
        </template>

        <!-- Analytics Data -->
        <template x-if="tab === 'analytics'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Index Status</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm"><span class="text-zinc-500">Pages indexed</span><span class="font-medium">4 / 4</span></div>
                        <div class="flex justify-between text-sm"><span class="text-zinc-500">With meta descriptions</span><span class="font-medium">3</span></div>
                        <div class="flex justify-between text-sm"><span class="text-zinc-500">With OG images</span><span class="font-medium">0</span></div>
                    </div>
                </div>
                <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Sitemap Info</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm"><span class="text-zinc-500">URLs</span><span class="font-medium">4</span></div>
                        <div class="flex justify-between text-sm"><span class="text-zinc-500">Last generated</span><span class="font-medium">Never</span></div>
                    </div>
                    <button @click="generateSitemap" class="mt-4 px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Generate Now</button>
                </div>
            </div>
        </template>

        <!-- Add Redirect Modal -->
        <template x-if="showAddRedirect">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="showAddRedirect = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-md w-full p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Add Redirect</h3>
                    <div class="space-y-3">
                        <div><label class="block text-sm font-medium mb-1">From</label><input type="text" x-model="newRedirect.from" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono" placeholder="/old-path" /></div>
                        <div><label class="block text-sm font-medium mb-1">To</label><input type="text" x-model="newRedirect.to" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono" placeholder="/new-path" /></div>
                        <div><label class="block text-sm font-medium mb-1">Type</label><select x-model="newRedirect.type" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><option value="301">301 - Permanent</option><option value="302">302 - Temporary</option></select></div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="showAddRedirect = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                        <button @click="addRedirect" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Add</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiSeoManager', (config) => ({
        pages: config.pages, redirects: config.redirects,
        showAddRedirect: false,
        newRedirect: { from: '', to: '', type: 301 },

        generateSitemap() { this.$dispatch('seo:generate-sitemap'); },
        addRedirect() {
            if (!this.newRedirect.from || !this.newRedirect.to) return;
            this.redirects.push({ ...this.newRedirect, status: 'active' });
            this.newRedirect = { from: '', to: '', type: 301 };
            this.showAddRedirect = false;
        },
    }));
});
</script>
