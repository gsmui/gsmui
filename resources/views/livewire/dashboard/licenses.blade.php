<div>
    <div class="max-w-4xl">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Licenses</h1>

        <div class="space-y-4">
            @forelse($licenses as $license)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $license->product->name ?? 'Unknown Product' }}</p>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                {{ $license->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : '' }}
                                {{ $license->status === 'expired' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}
                                {{ $license->status === 'inactive' ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' : '' }}">
                                {{ ucfirst($license->status) }}
                            </span>
                        </div>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">Expires {{ $license->expires_at?->format('M d, Y') ?? 'Never' }}</span>
                    </div>

                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex-1">
                            <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">License Key</label>
                            <div class="flex items-center gap-2">
                                <code class="flex-1 px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800 rounded-lg text-xs font-mono text-zinc-700 dark:text-zinc-300 truncate" id="key-{{ $license->id }}">
                                    {{ $license->key }}
                                </code>
                                <button wire:click="copyKey({{ $license->id }})" class="px-2 py-1.5 text-xs text-zinc-500 hover:text-purple-600 transition-colors" title="Copy key">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 flex items-center gap-4 text-xs text-zinc-500 dark:text-zinc-400">
                        <span>Activated {{ $license->activated_at?->diffForHumans() ?? 'Never' }}</span>
                        <span>&middot;</span>
                        <span>{{ $license->activations_count ?? 0 }} / {{ $license->max_activations ?? 'Unlimited' }} activations</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No licenses yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
