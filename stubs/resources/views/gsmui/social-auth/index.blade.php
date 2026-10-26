@php
$classes = Gsmui::classes()
    ->add('flex flex-col gap-6')
    ->add('p-6')
    ->toArray();
@endphp

<div {{ $attributes->merge(['class' => $classes[0]]) }}
     x-data="socialAuth()"
     x-init="init()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Social Authentication</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Manage social login providers for your application</p>
        </div>
    </div>

    {{-- Provider List --}}
    <div class="space-y-3">
        <template x-for="provider in providers" :key="provider.id">
            <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <template x-if="provider.icon === 'google'">
                            <svg class="h-8 w-8" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                        </template>
                        <template x-if="provider.icon === 'github'">
                            <svg class="h-8 w-8 text-zinc-900 dark:text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                            </svg>
                        </template>
                        <template x-if="provider.icon === 'facebook'">
                            <svg class="h-8 w-8" viewBox="0 0 24 24">
                                <path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </template>
                        <template x-if="provider.icon === 'twitter'">
                            <svg class="h-8 w-8 text-zinc-900 dark:text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </template>
                        <template x-if="provider.icon === 'microsoft'">
                            <svg class="h-8 w-8" viewBox="0 0 24 24">
                                <rect x="1" y="1" width="10.5" height="10.5" fill="#F25022"/>
                                <rect x="12.5" y="1" width="10.5" height="10.5" fill="#7FBA00"/>
                                <rect x="1" y="12.5" width="10.5" height="10.5" fill="#00A4EF"/>
                                <rect x="12.5" y="12.5" width="10.5" height="10.5" fill="#FFB900"/>
                            </svg>
                        </template>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-white" x-text="provider.name"></p>
                            <p class="text-xs text-zinc-400" x-text="provider.description"></p>
                            <template x-if="provider.connected">
                                <p class="text-xs text-green-600 dark:text-green-400 mt-0.5" x-text="'Connected as ' + provider.connectedEmail"></p>
                            </template>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span :class="provider.enabled ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400'"
                              class="px-2 py-0.5 text-xs font-medium rounded-full" x-text="provider.enabled ? 'Enabled' : 'Disabled'">
                        </span>
                        <button @click="toggleProvider(provider)" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors" :class="provider.enabled ? 'bg-(--color-accent)' : 'bg-zinc-300 dark:bg-zinc-600'" role="switch" :aria-checked="provider.enabled">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform" :class="provider.enabled ? 'translate-x-6' : 'translate-x-1'"></span>
                        </button>
                        <button @click="editProvider(provider)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Config Form (inline expand) --}}
                <template x-if="editing === provider.id">
                    <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-white/10 space-y-3">
                        <div>
                            <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">Client ID</label>
                            <input type="text" x-model="provider.config.clientId" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">Client Secret</label>
                            <div class="relative">
                                <input :type="provider.config.showSecret ? 'text' : 'password'" x-model="provider.config.clientSecret" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 px-3 py-2 pr-10 text-sm text-zinc-900 dark:text-white">
                                <button @click="provider.config.showSecret = !provider.config.showSecret" class="absolute right-2 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600">
                                    <svg x-show="!provider.config.showSecret" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="provider.config.showSecret" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">Redirect URL</label>
                            <input type="text" x-model="provider.config.redirectUrl" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white bg-zinc-50 dark:bg-zinc-700/50 text-zinc-400 cursor-not-allowed" readonly>
                        </div>
                        <div class="flex gap-2 pt-1">
                            <button @click="saveProvider(provider)" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-(--color-accent) text-white hover:opacity-90 transition-opacity">Save</button>
                            <button @click="editing = null" class="px-3 py-1.5 text-xs font-medium rounded-lg border border-zinc-200 dark:border-white/10 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">Cancel</button>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    {{-- Callback URL Info --}}
    <div class="rounded-xl border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 p-4">
        <div class="flex items-start gap-2">
            <svg class="h-5 w-5 text-blue-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Callback URL</p>
                <p class="text-xs text-blue-600 dark:text-blue-300 mt-1">Use the following callback URL when configuring these providers in their respective developer consoles:</p>
                <code class="mt-1 inline-block px-3 py-1.5 bg-blue-100 dark:bg-blue-900/40 rounded text-xs text-blue-700 dark:text-blue-300 font-mono">{{ url('/auth/social/callback') }}</code>
            </div>
        </div>
    </div>

    <script>
        function socialAuth() {
            return {
                editing: null,
                providers: [
                    {
                        id: 'google',
                        name: 'Google',
                        icon: 'google',
                        description: 'Google OAuth 2.0',
                        enabled: true,
                        connected: true,
                        connectedEmail: 'user@gmail.com',
                        config: { clientId: 'xxxxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com', clientSecret: '', redirectUrl: '{{ url("/auth/social/callback") }}', showSecret: false }
                    },
                    {
                        id: 'github',
                        name: 'GitHub',
                        icon: 'github',
                        description: 'GitHub OAuth App',
                        enabled: true,
                        connected: true,
                        connectedEmail: 'user@github.com',
                        config: { clientId: 'Iv1.xxxxxxxxxxxx', clientSecret: '', redirectUrl: '{{ url("/auth/social/callback") }}', showSecret: false }
                    },
                    {
                        id: 'facebook',
                        name: 'Facebook',
                        icon: 'facebook',
                        description: 'Facebook Login',
                        enabled: false,
                        connected: false,
                        connectedEmail: null,
                        config: { clientId: '', clientSecret: '', redirectUrl: '{{ url("/auth/social/callback") }}', showSecret: false }
                    },
                    {
                        id: 'twitter',
                        name: 'X (Twitter)',
                        icon: 'twitter',
                        description: 'X OAuth 2.0',
                        enabled: false,
                        connected: false,
                        connectedEmail: null,
                        config: { clientId: '', clientSecret: '', redirectUrl: '{{ url("/auth/social/callback") }}', showSecret: false }
                    },
                    {
                        id: 'microsoft',
                        name: 'Microsoft',
                        icon: 'microsoft',
                        description: 'Microsoft Entra ID',
                        enabled: false,
                        connected: false,
                        connectedEmail: null,
                        config: { clientId: '', clientSecret: '', redirectUrl: '{{ url("/auth/social/callback") }}', showSecret: false }
                    }
                ],

                toggleProvider(provider) {
                    provider.enabled = !provider.enabled;
                },

                editProvider(provider) {
                    this.editing = this.editing === provider.id ? null : provider.id;
                },

                saveProvider(provider) {
                    this.editing = null;
                }
            }
        }
    </script>
</div>
