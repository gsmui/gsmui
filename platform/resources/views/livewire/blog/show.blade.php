<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <article class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
                    @endif

                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-4">
                            @if($post->category)
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">{{ $post->category->name }}</span>
                            @endif
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $post->published_at?->format('M d, Y') }}</span>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>

                        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-zinc-200 dark:border-zinc-800">
                            <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-sm font-semibold text-zinc-600 dark:text-zinc-300">{{ substr($post->author->name, 0, 1) }}</div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $post->author->name }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $post->views_count }} views</p>
                            </div>
                        </div>

                        <div class="prose dark:prose-invert max-w-none">
                            {!! $post->body !!}
                        </div>

                        @if($post->tags && $post->tags->count())
                            <div class="mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($post->tags as $tag)
                                        <span class="px-2.5 py-1 text-xs rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </article>

                <div class="mt-8 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Comments ({{ $post->comments->count() }})</h2>

                    @auth
                        <form wire:submit="addComment" class="mb-8">
                            <textarea wire:model="commentBody" rows="3" placeholder="Write a comment..."
                                      class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-none"></textarea>
                            @error('commentBody') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            <div class="flex justify-end mt-3">
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Post Comment</button>
                            </div>
                        </form>
                    @else
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6"><a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700">Log in</a> to leave a comment.</p>
                    @endauth

                    <div class="space-y-4">
                        @forelse($post->comments as $comment)
                            <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-800">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ substr($comment->user->name, 0, 1) }}</div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">About the Author</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-lg font-bold text-zinc-600 dark:text-zinc-300">{{ substr($post->author->name, 0, 1) }}</div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $post->author->name }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $post->author->posts_count ?? 0 }} posts</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Share</h3>
                    <div class="flex gap-2">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="flex-1 text-center px-3 py-2 text-xs font-medium rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">Twitter</a>
                        <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="flex-1 text-center px-3 py-2 text-xs font-medium rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">LinkedIn</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
