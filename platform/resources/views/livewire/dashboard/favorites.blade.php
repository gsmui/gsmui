<div>
    <div class="max-w-4xl">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Favorites</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($favorites as $component)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4 flex items-center justify-between">
                    <div>
                        <a href="/components/{{ $component->slug }}" class="font-medium text-zinc-900 dark:text-white hover:text-purple-600 transition-colors">
                            {{ $component->name }}
                        </a>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $component->category }}</p>
                    </div>
                    <button wire:click="removeFavorite({{ $component->id }})" class="text-sm text-red-600 hover:text-red-700">
                        Remove
                    </button>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <p class="text-zinc-500 dark:text-zinc-400">No favorites yet.</p>
                    <a href="/components" class="inline-block mt-2 text-sm text-purple-600 hover:text-purple-700">Browse components →</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
