<div>
    <div class="max-w-4xl">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Favorites</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($favorites as $item)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($item->preview_image)
                            <img src="{{ $item->preview_image }}" alt="{{ $item->name }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route($item->getRoute() ?? 'components.show', $item->slug ?? $item->id) }}" class="font-medium text-zinc-900 dark:text-white hover:text-purple-600 transition-colors text-sm">
                                {{ $item->name }}
                            </a>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $item->category ?? $item->type ?? '' }}</p>
                        </div>
                    </div>
                    <button wire:click="removeFavorite({{ $item->id }})" class="text-xs text-red-600 hover:text-red-700 transition-colors">
                        Remove
                    </button>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-10 h-10 mx-auto text-zinc-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No favorites yet.</p>
                    <a href="{{ route('components.index') }}" class="inline-block mt-2 text-sm text-purple-600 hover:text-purple-700">Browse components</a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $favorites->links() }}
        </div>
    </div>
</div>
