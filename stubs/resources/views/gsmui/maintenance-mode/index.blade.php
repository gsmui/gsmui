@props([
    'enabled' => false,
    'whitelist' => [],
    'secret' => '',
    'class' => '',
])

<?php
$id = 'maintenance-mode-' . uniqid();
$whitelist = $whitelist ?: ['127.0.0.1', '192.168.1.100', '10.0.0.1'];
?>

<div 
    class="gsmui-maintenance-mode {{ $class }}"
    x-data="gsmuiMaintenanceMode({
        enabled: @js($enabled),
        whitelist: @js($whitelist),
        secret: @js($secret),
    })"
    id="{{ $id }}"
>
    <div class="max-w-2xl mx-auto space-y-6">
        <div><h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Maintenance Mode</h2><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Control application availability and downtime.</p></div>

        <!-- Status Card -->
        <div class="p-6 rounded-xl border transition-colors"
            :class="enabled ? 'border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20' : 'border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20'">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full flex items-center justify-center"
                    :class="enabled ? 'bg-amber-100 dark:bg-amber-900/30' : 'bg-emerald-100 dark:bg-emerald-900/30'">
                    <svg class="w-8 h-8" :class="enabled ? 'text-amber-600' : 'text-emerald-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-lg font-semibold" :class="enabled ? 'text-amber-800 dark:text-amber-300' : 'text-emerald-800 dark:text-emerald-300'" x-text="enabled ? 'Application is in maintenance mode' : 'Application is live'"></div>
                    <p class="text-sm mt-0.5" :class="enabled ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400'">
                        <span x-text="enabled ? 'All visitors will see a maintenance page (except whitelisted IPs).' : 'All visitors can access the application normally.'"></span>
                    </p>
                </div>
                <button @click="toggleMode" class="px-6 py-3 rounded-lg text-sm font-semibold text-white transition-colors"
                    :class="enabled ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-amber-600 hover:bg-amber-700'"
                    x-text="enabled ? 'Bring Online' : 'Enable Maintenance'">
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Settings -->
            <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Settings</h3>
                <div class="space-y-3">
                    <div><label class="block text-sm font-medium mb-1">Secret (bypass URL)</label>
                        <div class="flex gap-2">
                            <input type="text" x-model="secret" class="flex-1 px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono" placeholder="my-secret-key" />
                            <button @click="regenerateSecret" class="px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50">Regenerate</button>
                        </div>
                        <p class="text-xs text-zinc-500 mt-1">Access: <code class="font-mono" x-text="'/maintenance/' + secret"></code></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Retry-After (seconds)</label>
                        <input type="number" x-model="retryAfter" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" value="3600" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Custom Message</label>
                        <textarea x-model="customMessage" rows="3" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" placeholder="We are performing scheduled maintenance..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Whitelist -->
            <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-zinc-900 dark:text-white">IP Whitelist</h3>
                    <button @click="showAddIp = true" class="px-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50">+ Add IP</button>
                </div>
                <div class="space-y-2">
                    <template x-for="(ip, i) in whitelist" :key="i">
                        <div class="flex items-center justify-between px-3 py-2 rounded-lg bg-zinc-50 dark:bg-zinc-900">
                            <code class="text-sm font-mono text-zinc-800 dark:text-zinc-200" x-text="ip"></code>
                            <button @click="removeIp(i)" class="p-1 text-zinc-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                    </template>
                    <template x-if="whitelist.length === 0">
                        <p class="text-sm text-zinc-500 text-center py-4">No IPs whitelisted.</p>
                    </template>
                </div>
            </div>
        </div>

        <!-- Preview Banner -->
        <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">Preview Maintenance Page</h3>
            <div class="bg-zinc-900 rounded-xl p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-amber-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <h1 class="text-white text-2xl font-bold mb-2">Under Maintenance</h1>
                <p class="text-zinc-400 mb-4" x-text="customMessage || 'We are performing scheduled maintenance. We will be back shortly.'"></p>
                <div class="inline-flex items-center gap-2 text-sm text-zinc-500"><svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Retry in <span x-text="retryAfter || 3600"></span> seconds</div>
            </div>
        </div>

        <!-- Add IP Modal -->
        <template x-if="showAddIp">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="showAddIp = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-sm w-full p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Add IP to Whitelist</h3>
                    <input type="text" x-model="newIp" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono" placeholder="192.168.1.0" @keydown.enter.prevent="addIp" />
                    <div class="flex justify-end gap-3 mt-4">
                        <button @click="showAddIp = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                        <button @click="addIp" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Add</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiMaintenanceMode', (config) => ({
        enabled: config.enabled, whitelist: config.whitelist, secret: config.secret || 'maintenance-secret',
        retryAfter: 3600, customMessage: '',
        showAddIp: false, newIp: '',
        toggleMode() { this.enabled = !this.enabled; this.$dispatch('maintenance:toggle', { enabled: this.enabled }); },
        regenerateSecret() { this.secret = 'secret-' + Math.random().toString(36).slice(2, 10); },
        addIp() { if (this.newIp) { this.whitelist.push(this.newIp); this.newIp = ''; this.showAddIp = false; } },
        removeIp(i) { this.whitelist.splice(i, 1); },
    }));
});
</script>
