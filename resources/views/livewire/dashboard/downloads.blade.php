<div>
    <div class="max-w-4xl">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Downloads</h1>

        <div class="space-y-4">
            @forelse($downloads as $download)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        </div>
                        <div>
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $download->name }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                v{{ $download->version }} &middot; {{ $download->file_size ? round($download->file_size / 1024, 1) . ' KB' : 'Unknown size' }}
                                &middot; Downloaded {{ $download->pivot->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($download->latest_version && $download->latest_version !== $download->version)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300">Update available</span>
                        @endif
                        <a href="{{ route('downloads.file', $download->id) }}"
                           class="px-3 py-1.5 text-xs font-medium rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition-colors">
                            Download
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No downloads yet.</p>
                    <a href="{{ route('marketplace.index') }}" class="inline-block mt-2 text-sm text-purple-600 hover:text-purple-700">Browse Marketplace</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
