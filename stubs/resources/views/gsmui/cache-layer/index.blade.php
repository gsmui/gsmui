@props([
    'stores' => [],
    'keys' => [],
    'stats' => [],
    'class' => '',
])

<?php
$id = 'cache-layer-' . uniqid();
$stores = $stores ?: [
    ['name' => 'redis', 'driver' => 'Redis', 'status' => 'connected', 'keys' => 1523, 'memory' => '12.4 MB', 'hit_rate' => 94],
    ['name' => 'file', 'driver' => 'File', 'status' => 'connected', 'keys' => 8432, 'memory' => '48.2 MB', 'hit_rate' => 87],
    ['name' => 'memcached', 'driver' => 'Memcached', 'status' => 'disconnected', 'keys' => 0, 'memory' => '0 B', 'hit_rate' => 0],
];
$keys = $keys ?: [
    ['key' => 'app:settings', 'store' => 'redis', 'ttl' => 3600, 'size' => '2.1 KB'],
    ['key' => 'app:users:active', 'store' => 'redis', 'ttl' => 300, 'size' => '45.6 KB'],
    ['key' => 'app:posts:latest', 'store' => 'file', 'ttl' => 600, 'size' => '12.3 KB'],
];
?>

<div 
    class="gsmui-cache-layer {{ $class }}"
    x-data="gsmuiCacheLayer({
        stores: @js($stores),
        keys: @js($keys),
        stats: @js($stats),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Cache Manager</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Monitor and manage cache stores and keys.</p>
            </div>
            <button @click="clearAll" class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 transition-colors">Clear All Cache</button>
        </div>

        <!-- Store Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <template x-for="store in stores" :key="store.name">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-medium text-zinc-900 dark:text-white capitalize" x-text="store.name"></h3>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                            :class="store.status === 'connected' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400'"
                            x-text="store.status">
                        </span>
                    </div>
                    <div class="text-xs text-zinc-500 dark:text-zinc-400 space-y-1">
                        <div class="flex justify-between"><span>Driver</span><span class="font-medium text-zinc-900 dark:text-white" x-text="store.driver"></span></div>
                        <div class="flex justify-between"><span>Keys</span><span class="font-medium text-zinc-900 dark:text-white" x-text="store.keys.toLocaleString()"></span></div>
                        <div class="flex justify-between"><span>Memory</span><span class="font-medium text-zinc-900 dark:text-white" x-text="store.memory"></span></div>
                    </div>
                    <div class="mt-3">
                        <div class="flex justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-1">
                            <span>Hit Rate</span>
                            <span x-text="store.hit_rate + '%'"></span>
                        </div>
                        <div class="h-1.5 bg-zinc-100 dark:bg-zinc-700 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all" :class="store.hit_rate > 90 ? 'bg-emerald-500' : store.hit_rate > 70 ? 'bg-amber-500' : 'bg-red-500'" :style="{ width: store.hit_rate + '%' }"></div>
                        </div>
                    </div>
                    <button @click="clearStore(store)" class="mt-3 w-full px-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">Clear <span x-text="store.name"></span></button>
                </div>
            </template>
        </div>

        <!-- Cache Keys -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Cache Keys</h3>
                <div class="flex items-center gap-2">
                    <select x-model="filterStore" class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                        <option value="">All Stores</option>
                        <template x-for="store in stores" :key="store.name">
                            <option :value="store.name" x-text="store.name"></option>
                        </template>
                    </select>
                    <select x-model="sortBy" class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                        <option value="key">Key</option>
                        <option value="ttl">TTL</option>
                    </select>
                </div>
            </div>
            <table class="w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Key</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Store</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">TTL (s)</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Size</th>
                        <th class="text-right px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <template x-for="key in filteredKeys" :key="key.key">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3"><code class="text-sm font-mono text-zinc-900 dark:text-white" x-text="key.key"></code></td>
                            <td class="px-4 py-3 text-sm text-zinc-500 capitalize" x-text="key.store"></td>
                            <td class="px-4 py-3 text-right text-sm text-zinc-600 dark:text-zinc-400 tabular-nums" x-text="key.ttl.toLocaleString()"></td>
                            <td class="px-4 py-3 text-right text-sm text-zinc-600 dark:text-zinc-400" x-text="key.size"></td>
                            <td class="px-4 py-3 text-right">
                                <button @click="forgetKey(key)" class="p-1 text-zinc-400 hover:text-red-500 transition-colors" title="Forget">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <template x-if="filteredKeys.length === 0">
                <div class="p-8 text-center text-zinc-500 dark:text-zinc-400">No cache keys found</div>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiCacheLayer', (config) => ({
        stores: config.stores,
        keys: config.keys,
        stats: config.stats,
        filterStore: '',
        sortBy: 'key',

        get filteredKeys() {
            let result = [...this.keys];
            if (this.filterStore) result = result.filter(k => k.store === this.filterStore);
            result.sort((a, b) => a[this.sortBy] > b[this.sortBy] ? 1 : -1);
            return result;
        },

        clearStore(store) {
            this.keys = this.keys.filter(k => k.store !== store.name);
            store.keys = 0;
            store.memory = '0 B';
        },

        clearAll() {
            this.stores.forEach(s => { s.keys = 0; s.memory = '0 B'; });
            this.keys = [];
        },

        forgetKey(key) {
            this.keys = this.keys.filter(k => k.key !== key.key);
            const store = this.stores.find(s => s.name === key.store);
            if (store) { store.keys--; }
        },
    }));
});
</script>
