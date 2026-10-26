<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex gap-8">
            <aside class="w-64 flex-shrink-0">
                <nav class="sticky top-24 space-y-1">
                    <h3 class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-3">{{ $document->category }}</h3>
                    @foreach($sidebarDocs as $doc)
                        <a href="{{ route('docs.show', $doc->slug) }}"
                           class="block px-3 py-2 text-sm rounded-lg transition-colors {{ $doc->id === $document->id ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                            {{ $doc->title }}
                        </a>
                    @endforeach
                </nav>
            </aside>

            <main class="flex-1 min-w-0">
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">{{ $document->category }}</span>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">v{{ $document->version }}</span>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $document->title }}</h1>

                    <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400 mb-8">
                        <span>by {{ $document->author->name }}</span>
                        <span class="mx-2">·</span>
                        <span>{{ $document->views_count }} views</span>
                    </div>

                    <div class="prose dark:prose-invert max-w-none">
                        {!! $document->body !!}
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
