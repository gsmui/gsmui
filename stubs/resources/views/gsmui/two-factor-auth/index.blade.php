@props([
    'enabled' => false,
    'methods' => [],
    'recoveryCodes' => [],
    'class' => '',
])

<?php
$id = 'two-factor-auth-' . uniqid();
$methods = $methods ?: [
    ['id' => 'app', 'name' => 'Authenticator App', 'description' => 'Use Google Authenticator, Authy, or similar', 'icon' => 'device-phone-mobile', 'setup' => false],
    ['id' => 'sms', 'name' => 'SMS', 'description' => 'Receive codes via text message', 'icon' => 'device-phone-mobile', 'setup' => false],
];
?>

<div 
    class="gsmui-two-factor-auth {{ $class }}"
    x-data="gsmuiTwoFactorAuth({
        enabled: @js($enabled),
        methods: @js($methods),
        recoveryCodes: @js($recoveryCodes),
    })"
    id="{{ $id }}"
>
    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Two-Factor Authentication</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Add an extra layer of security to your account.</p>
        </div>

        <!-- Status Card -->
        <div class="p-5 rounded-xl border transition-colors"
            :class="enabled ? 'border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20' : 'border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800'">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full flex items-center justify-center"
                    :class="enabled ? 'bg-emerald-100 dark:bg-emerald-900/30' : 'bg-zinc-100 dark:bg-zinc-700'">
                    <svg class="w-6 h-6" :class="enabled ? 'text-emerald-600' : 'text-zinc-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="font-medium text-zinc-900 dark:text-white">
                        <span x-text="enabled ? 'Two-factor authentication is enabled' : 'Two-factor authentication is disabled'"></span>
                    </div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5" x-text="enabled ? 'Your account is protected with an additional verification step.' : 'Protect your account with an additional verification step.'"></p>
                </div>
                <button @click="enabled = !enabled" 
                    class="px-4 py-2 text-sm rounded-lg transition-colors"
                    :class="enabled ? 'bg-red-50 dark:bg-red-900/20 text-red-600 border border-red-200 dark:border-red-800 hover:bg-red-100' : 'bg-primary text-white hover:bg-primary/90'"
                    x-text="enabled ? 'Disable' : 'Enable'">
                </button>
            </div>
        </div>

        <!-- Setup Methods -->
        <template x-if="!enabled">
            <div class="space-y-3">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Choose a method</h3>
                <template x-for="method in methods" :key="method.id">
                    <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-sm transition-shadow cursor-pointer"
                        @click="setupMethod(method)">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center">
                                <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-zinc-900 dark:text-white" x-text="method.name"></div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400" x-text="method.description"></div>
                            </div>
                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <!-- Setup Modal -->
        <template x-if="showSetup && !enabled">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="showSetup = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-lg w-full p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Set up Authenticator App</h3>
                    <div class="space-y-4">
                        <div class="p-4 bg-zinc-100 dark:bg-zinc-900 rounded-lg text-center">
                            <div class="w-40 h-40 mx-auto bg-white dark:bg-zinc-800 rounded-lg border-2 border-dashed border-zinc-300 dark:border-zinc-600 flex items-center justify-center mb-3">
                                <svg class="w-12 h-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <p class="text-sm font-mono text-zinc-800 dark:text-zinc-200">GSMUI-XXXX-XXXX-XXXX</p>
                        </div>
                        <ol class="list-decimal list-inside space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                            <li>Install an authenticator app (Google Authenticator, Authy)</li>
                            <li>Open the app and scan the QR code or enter the key manually</li>
                            <li>Enter the 6-digit code from the app below</li>
                        </ol>
                        <div>
                            <label class="block text-sm font-medium mb-1">Verification Code</label>
                            <input type="text" x-model="setupCode" maxlength="6" class="w-full px-3 py-2 text-center text-lg tracking-[0.5em] font-mono border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="000000" />
                        </div>
                        <div class="flex justify-end gap-3">
                            <button @click="showSetup = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                            <button @click="confirmSetup" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Verify & Enable</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Recovery Codes -->
        <template x-if="enabled">
            <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">Recovery Codes</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">Save these one-time use codes in a secure place. If you lose access to your authenticator app, you can use these to sign in.</p>
                <div class="grid grid-cols-2 gap-2 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg font-mono text-sm">
                    <template x-for="code in recoveryCodes.length > 0 ? recoveryCodes : ['XXXXX-XXXXX', 'XXXXX-XXXXX', 'XXXXX-XXXXX', 'XXXXX-XXXXX', 'XXXXX-XXXXX', 'XXXXX-XXXXX']" :key="code">
                        <code class="text-zinc-800 dark:text-zinc-200" x-text="code"></code>
                    </template>
                </div>
                <div class="flex gap-2 mt-4">
                    <button @click="regenerateCodes" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700">Regenerate</button>
                    <button @click="copyCodes" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700">Copy Codes</button>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiTwoFactorAuth', (config) => ({
        enabled: config.enabled,
        methods: config.methods,
        recoveryCodes: config.recoveryCodes,
        showSetup: false,
        setupCode: '',
        setupMethodId: '',

        setupMethod(method) {
            this.setupMethodId = method.id;
            this.showSetup = true;
        },

        confirmSetup() {
            if (this.setupCode.length === 6) {
                this.enabled = true;
                this.showSetup = false;
                this.setupCode = '';
                this.$dispatch('2fa:enabled');
            }
        },

        regenerateCodes() {
            this.recoveryCodes = Array.from({ length: 6 }, () => {
                const r = () => Math.random().toString(36).toUpperCase().slice(2, 7);
                return r() + '-' + r();
            });
        },

        copyCodes() {
            const text = this.recoveryCodes.join('\n');
            navigator.clipboard.writeText(text);
        },
    }));
});
</script>
