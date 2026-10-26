<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            @if($item->screenshot)
                <img src="{{ $item->screenshot }}" alt="{{ $item->title }}" class="w-full h-64 object-cover">
            @else
                <div class="w-full h-64 bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
            @endif

            <div class="p-8">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $item->title }}</h1>
                    <div class="flex items-center gap-3">
                        <button wire:click="toggleLike" class="flex items-center gap-1 text-zinc-500 hover:text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            <span class="text-sm">{{ $item->likes_count }}</span>
                        </button>
                        <a href="{{ $item->url }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                            Visit Site
                        </a>
                    </div>
                </div>

                <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400 mb-6">
                    <span>by {{ $item->user->name }}</span>
                    <span class="mx-2">·</span>
                    <span>{{ $item->views_count }} views</span>
                    <span class="mx-2">·</span>
                    <span>{{ $item->created_at->diffForHumans() }}</span>
                </div>

                @if($item->tags)
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($item->tags as $tag)
                            <span class="px-3 py-1 text-sm rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="prose dark:prose-invert max-w-none mb-8">
                    {!! $item->description !!}
                </div>

                <div class="border-t border-zinc-200 dark:border-zinc-800 pt-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Comments</h2>

                    @auth
                        <form wire:submit="addComment" class="mb-6">
                            <textarea wire:model="commentBody" rows="3" placeholder="Add a comment..."
                                      class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-y mb-3"></textarea>
                            @error('commentBody') <p class="text-sm text-red-600 mb-2">{{ $message }}</p> @enderror
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Post Comment</button>
                        </form>
                    @else
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6"><a href="{{ route('login') }}" class="text-purple-600 hover:underline">Login</a> to comment.</p>
                    @endauth

                    <div class="space-y-4">
                        @forelse($item->comments as $comment)
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No comments yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
