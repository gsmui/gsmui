<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Documentation</h1>
            @auth
                <a href="{{ route('docs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                    Create Document
                </a>
            @endauth
        </div>

        <div class="mb-6 flex flex-wrap gap-4">
            <input type="text" wire:model.live="search" placeholder="Search documentation..."
                   class="flex-1 min-w-0 rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
        </div>

        @if($categories->count())
            <div class="mb-6 flex flex-wrap gap-2">
                <button wire:click="$set('category', null)"
                        class="px-3 py-1 rounded-full text-sm transition-colors {{ is_null($category) ? 'bg-purple-600 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}">
                    All
                </button>
                @foreach($categories as $cat)
                    <button wire:click="$set('category', '{{ $cat }}')"
                            class="px-3 py-1 rounded-full text-sm transition-colors {{ $category === $cat ? 'bg-purple-600 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="space-y-4">
            @forelse($documents as $document)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">{{ $document->category }}</span>
                                @if($document->subcategory)
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">/ {{ $document->subcategory }}</span>
                                @endif
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                <a href="{{ route('docs.show', $document->slug) }}" class="hover:text-purple-600 transition-colors">{{ $document->title }}</a>
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit(strip_tags($document->body), 150) }}</p>
                        </div>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 ml-4">v{{ $document->version }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <span>by {{ $document->author->name }}</span>
                        <span>{{ $document->views_count }} views</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No documents found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $documents->links() }}
        </div>
    </div>
</div>
