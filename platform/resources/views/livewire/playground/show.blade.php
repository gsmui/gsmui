<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center gap-4">
                    <h1 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $project->name }}</h1>
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300">{{ $project->language }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <button wire:click="toggleLike" class="flex items-center gap-1 text-zinc-500 hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        <span class="text-sm">{{ $project->likes_count }}</span>
                    </button>
                    @auth
                        <button wire:click="fork" class="inline-flex items-center px-3 py-1.5 border border-zinc-300 dark:border-zinc-700 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            Fork
                        </button>
                        @if(auth()->id() === $project->user_id)
                            <button wire:click="saveCode" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                                Save
                            </button>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-zinc-200 dark:divide-zinc-800">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-zinc-300">Code</h3>
                        <button wire:click="runCode" wire:loading.attr="disabled" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 transition-colors disabled:opacity-50">
                            <span wire:loading.remove wire:target="runCode">Run</span>
                            <span wire:loading wire:target="runCode">Running...</span>
                        </button>
                    </div>
                    <textarea wire:model="code" rows="20"
                              class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm dark:text-white font-mono focus:ring-purple-500 focus:border-purple-500 resize-none"
                              placeholder="Write your code here..."></textarea>
                </div>

                <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Output</h3>
                    <div class="h-[500px] rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 p-4 overflow-auto">
                        @if($output)
                            <pre class="text-sm text-zinc-600 dark:text-zinc-400 whitespace-pre-wrap">{{ $output }}</pre>
                        @else
                            <p class="text-sm text-zinc-400 dark:text-zinc-500">Click "Run" to see output.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400">
                    <span>by {{ $project->user->name }}</span>
                    <span class="mx-2">·</span>
                    <span>{{ $project->views_count }} views</span>
                    @if($project->last_run_at)
                        <span class="mx-2">·</span>
                        <span>Last run {{ $project->last_run_at->diffForHumans() }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
