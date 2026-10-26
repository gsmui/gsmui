@props([
    'flags' => [],
    'class' => '',
])

<?php
$id = 'feature-flags-' . uniqid();
$flags = $flags ?: [
    ['id' => 1, 'key' => 'new-dashboard', 'name' => 'New Dashboard', 'description' => 'Enable the redesigned dashboard experience', 'enabled' => true, 'percentage' => 100, 'environment' => 'production'],
    ['id' => 2, 'key' => 'dark-mode', 'name' => 'Dark Mode', 'description' => 'Allow users to switch to dark mode', 'enabled' => true, 'percentage' => 100, 'environment' => 'production'],
    ['id' => 3, 'key' => 'beta-charts', 'name' => 'Beta Charts', 'description' => 'New charting library (beta)', 'enabled' => false, 'percentage' => 25, 'environment' => 'staging'],
    ['id' => 4, 'key' => 'ai-assistant', 'name' => 'AI Assistant', 'description' => 'AI-powered writing assistant', 'enabled' => false, 'percentage' => 10, 'environment' => 'development'],
    ['id' => 5, 'key' => 'export-csv', 'name' => 'CSV Export', 'description' => 'Enable CSV export functionality', 'enabled' => true, 'percentage' => 100, 'environment' => 'production'],
];
?>

<div 
    class="gsmui-feature-flags {{ $class }}"
    x-data="gsmuiFeatureFlags({
        flags: @js($flags),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Feature Flags</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage feature toggles across environments.</p>
            </div>
            <button @click="showAddFlag = true" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ Add Flag</button>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="flags.length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Total Flags</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-emerald-600" x-text="flags.filter(f => f.enabled).length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Active</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-500" x-text="flags.filter(f => !f.enabled).length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Inactive</div>
            </div>
        </div>

        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <table class="w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Flag</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Key</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Environment</th>
                        <th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Rollout</th>
                        <th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <template x-for="flag in flags" :key="flag.id">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3">
                                <div class="font-medium text-sm text-zinc-900 dark:text-white" x-text="flag.name"></div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400" x-text="flag.description"></div>
                            </td>
                            <td class="px-4 py-3"><code class="text-xs font-mono text-zinc-600 dark:text-zinc-400" x-text="flag.key"></code></td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-0.5 rounded-full capitalize"
                                    :class="{
                                        'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700': flag.environment === 'production',
                                        'bg-amber-100 dark:bg-amber-900/30 text-amber-700': flag.environment === 'staging',
                                        'bg-blue-100 dark:bg-blue-900/30 text-blue-700': flag.environment === 'development',
                                    }"
                                    x-text="flag.environment">
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-20 h-1.5 bg-zinc-100 dark:bg-zinc-700 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full bg-primary transition-all" :style="{ width: flag.percentage + '%' }"></div>
                                    </div>
                                    <span class="text-xs text-zinc-500" x-text="flag.percentage + '%'"></span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button @click="toggleFlag(flag)" class="relative w-10 h-5 rounded-full transition-colors"
                                    :class="flag.enabled ? 'bg-primary' : 'bg-zinc-300 dark:bg-zinc-600'">
                                    <div class="absolute w-4 h-4 bg-white rounded-full shadow top-0.5 transition-transform"
                                        :class="flag.enabled ? 'translate-x-[22px]' : 'translate-x-0.5'">
                                    </div>
                                </button>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button @click="deleteFlag(flag)" class="p-1 text-zinc-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Add Flag Modal -->
        <template x-if="showAddFlag">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="showAddFlag = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-md w-full p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">New Feature Flag</h3>
                    <div class="space-y-3">
                        <div><label class="block text-sm font-medium mb-1">Name</label><input type="text" x-model="newFlag.name" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" /></div>
                        <div><label class="block text-sm font-medium mb-1">Key</label><input type="text" x-model="newFlag.key" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono" /></div>
                        <div><label class="block text-sm font-medium mb-1">Description</label><textarea x-model="newFlag.description" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" rows="2"></textarea></div>
                        <div><label class="block text-sm font-medium mb-1">Environment</label><select x-model="newFlag.environment" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><option value="development">Development</option><option value="staging">Staging</option><option value="production">Production</option></select></div>
                        <div><label class="block text-sm font-medium mb-1">Rollout %</label><input type="range" x-model="newFlag.percentage" min="0" max="100" class="w-full" /><span class="text-xs text-zinc-500" x-text="newFlag.percentage + '%'"></span></div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="showAddFlag = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                        <button @click="addFlag" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Create Flag</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiFeatureFlags', (config) => ({
        flags: config.flags,
        showAddFlag: false,
        newFlag: { name: '', key: '', description: '', environment: 'development', percentage: 100, enabled: false },

        toggleFlag(flag) { flag.enabled = !flag.enabled; },

        deleteFlag(flag) { this.flags = this.flags.filter(f => f.id !== flag.id); },

        addFlag() {
            if (!this.newFlag.name || !this.newFlag.key) return;
            this.flags.push({ id: Date.now(), ...this.newFlag });
            this.newFlag = { name: '', key: '', description: '', environment: 'development', percentage: 100, enabled: false };
            this.showAddFlag = false;
        },
    }));
});
</script>
