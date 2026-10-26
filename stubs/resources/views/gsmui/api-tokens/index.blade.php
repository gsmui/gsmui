@props([
    'tokens' => [],
    'class' => '',
])

<?php
$id = 'api-tokens-' . uniqid();
$tokens = $tokens ?: [
    ['id' => 1, 'name' => 'Production API', 'token' => 'gsmui_pk_...a1b2c3', 'permissions' => ['read', 'write'], 'last_used' => '2m ago', 'created' => '2024-01-01', 'expires' => '2025-01-01'],
    ['id' => 2, 'name' => 'Development', 'token' => 'gsmui_pk_...d4e5f6', 'permissions' => ['read', 'write', 'admin'], 'last_used' => '1h ago', 'created' => '2024-01-10', 'expires' => '2025-01-10'],
    ['id' => 3, 'name' => 'CI/CD Pipeline', 'token' => 'gsmui_pk_...g7h8i9', 'permissions' => ['read'], 'last_used' => '1d ago', 'created' => '2024-01-15', 'expires' => '2024-12-31'],
];
?>

<div 
    class="gsmui-api-tokens {{ $class }}"
    x-data="gsmuiApiTokens({
        tokens: @js($tokens),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">API Tokens</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage API keys for programmatic access.</p>
            </div>
            <button @click="showCreate = true" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ Generate Token</button>
        </div>

        <div class="space-y-3">
            <template x-for="(token, index) in tokens" :key="token.id">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-zinc-900 dark:text-white" x-text="token.name"></h3>
                            <code class="text-xs font-mono text-zinc-500 dark:text-zinc-400 mt-0.5 block" x-text="token.token"></code>
                        </div>
                        <div class="flex items-center gap-2">
                            <button @click="copyToken(token)" class="px-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">Copy</button>
                            <button @click="revokeToken(token)" class="px-3 py-1.5 text-xs bg-red-50 dark:bg-red-900/20 text-red-600 border border-red-200 dark:border-red-800 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">Revoke</button>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-3 text-xs text-zinc-500 dark:text-zinc-400">
                        <span x-text="'Created: ' + token.created"></span>
                        <span x-text="'Expires: ' + token.expires"></span>
                        <span x-text="'Last used: ' + token.last_used"></span>
                    </div>
                    <div class="flex flex-wrap gap-1.5 mt-2">
                        <template x-for="perm in token.permissions" :key="perm">
                            <span class="text-xs px-2 py-0.5 rounded-full capitalize"
                                :class="{
                                    'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400': perm === 'read',
                                    'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400': perm === 'write',
                                    'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400': perm === 'admin',
                                }"
                                x-text="perm">
                            </span>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- Create Token Modal -->
        <template x-if="showCreate">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="showCreate = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-md w-full p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Generate API Token</h3>
                    <div class="space-y-3">
                        <div><label class="block text-sm font-medium mb-1">Token Name</label><input type="text" x-model="newToken.name" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" placeholder="e.g., Production CI" /></div>
                        <div><label class="block text-sm font-medium mb-1">Permissions</label>
                            <div class="space-y-1">
                                <template x-for="perm in ['read', 'write', 'admin']" :key="perm">
                                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" :value="perm" x-model="newToken.permissions" class="w-4 h-4 text-primary rounded border-zinc-300" /><span class="capitalize" x-text="perm"></span></label>
                                </template>
                            </div>
                        </div>
                        <div><label class="block text-sm font-medium mb-1">Expires</label><input type="date" x-model="newToken.expires" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" /></div>
                    </div>
                    <template x-if="generatedToken">
                        <div class="mt-4 p-3 bg-zinc-900 rounded-lg">
                            <label class="block text-xs font-medium text-zinc-400 mb-1">Your token (copy now — won't be shown again)</label>
                            <code class="block text-sm font-mono text-green-400 break-all" x-text="generatedToken"></code>
                        </div>
                    </template>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="showCreate = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                        <button @click="generateToken" :disabled="!newToken.name || newToken.permissions.length === 0" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90 disabled:opacity-50">Generate</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiApiTokens', (config) => ({
        tokens: config.tokens,
        showCreate: false,
        newToken: { name: '', permissions: [], expires: '' },
        generatedToken: '',

        copyToken(token) {
            navigator.clipboard.writeText(token.token);
        },

        revokeToken(token) {
            this.tokens = this.tokens.filter(t => t.id !== token.id);
        },

        generateToken() {
            const chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
            const key = Array.from({ length: 40 }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
            this.generatedToken = 'gsmui_pk_' + key;

            this.tokens.push({
                id: Date.now(),
                name: this.newToken.name,
                token: this.generatedToken.slice(0, 20) + '...',
                permissions: [...this.newToken.permissions],
                last_used: 'Never',
                created: new Date().toISOString().slice(0, 10),
                expires: this.newToken.expires || 'Never',
            });

            this.newToken = { name: '', permissions: [], expires: '' };
        },
    }));
});
</script>
