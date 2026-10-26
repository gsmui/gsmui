<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Blog</h1>
            @auth
                <a href="{{ route('blog.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                    Write Post
                </a>
            @endauth
        </div>

        <div class="mb-6 flex flex-wrap gap-4">
            <input type="text" wire:model.live="search" placeholder="Search posts..."
                   class="flex-1 min-w-0 rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
        </div>

        @if($categories->count())
            <div class="mb-6 flex flex-wrap gap-2">
                <button wire:click="$set('category', null)"
                        class="px-3 py-1 rounded-full text-sm transition-colors {{ is_null($category) ? 'bg-purple-600 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}">
                    All
                </button>
                @foreach($categories as $cat)
                    <button wire:click="$set('category', {{ $cat->id }})"
                            class="px-3 py-1 rounded-full text-sm transition-colors {{ $category == $cat->id ? 'bg-purple-600 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
                <article class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden hover:shadow-lg transition-shadow">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            @if($post->category)
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">{{ $post->category->name }}</span>
                            @endif
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $post->published_at?->diffForHumans() }}</span>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-purple-600 transition-colors">{{ $post->title }}</a>
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit(strip_tags($post->body), 120) }}</p>
                        <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                            <span>by {{ $post->author->name }}</span>
                            <div class="flex items-center gap-3">
                                <span>{{ $post->views_count }} views</span>
                                <span>{{ $post->comments_count }} comments</span>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-16 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No posts found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>
