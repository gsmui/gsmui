<div>
    <div class="max-w-4xl">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">API Keys</h1>
            <button wire:click="$set('showModal', true)" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                Create Key
            </button>
        </div>

        <div class="space-y-4">
            @forelse($apiKeys as $key)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $key->name }}</p>
                            <p class="text-sm font-mono text-zinc-500 dark:text-zinc-400">{{ substr($key->key, 0, 12) }}...</p>
                            <p class="text-xs text-zinc-400 mt-1">Last used: {{ $key->last_used_at?->diffForHumans() ?? 'Never' }}</p>
                        </div>
                        <button wire:click="deleteApiKey({{ $key->id }})" wire:confirm="Delete this API key?" class="text-sm text-red-600 hover:text-red-700 transition-colors">
                            Delete
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-10 h-10 mx-auto text-zinc-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No API keys yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xl w-full max-w-md p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Create API Key</h2>
                <form wire:submit="createApiKey">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Name</label>
                        <input type="text" wire:model="newKeyName" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500" placeholder="My API Key">
                        @error('newKeyName') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Create</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
