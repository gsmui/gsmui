<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $chart->name }}</h1>
                <div class="flex items-center gap-3">
                    <button wire:click="toggleFavorite" class="flex items-center gap-1 text-zinc-500 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                    </button>
                    @auth
                        <button wire:click="fork" class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-700 text-sm font-medium rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            Fork
                        </button>
                    @endauth
                </div>
            </div>

            <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400 mb-6">
                <span>by {{ $chart->user->name }}</span>
                <span class="mx-2">·</span>
                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300">{{ ucfirst($chart->type) }}</span>
                <span class="mx-2">·</span>
                <span>{{ $chart->views_count }} views</span>
            </div>

            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-xl p-8 mb-8">
                <div class="h-64 flex items-center justify-center">
                    <svg class="w-24 h-24 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
                <p class="text-center text-sm text-zinc-500 dark:text-zinc-400 mt-4">Chart visualization would render here</p>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Data</h3>
                    <pre class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-4 text-xs text-zinc-600 dark:text-zinc-400 overflow-x-auto">{{ json_encode($chart->data, JSON_PRETTY_PRINT) }}</pre>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Config</h3>
                    <pre class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-4 text-xs text-zinc-600 dark:text-zinc-400 overflow-x-auto">{{ json_encode($chart->config, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>
