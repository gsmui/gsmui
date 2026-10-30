<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            @if($template->preview_image)
                <img src="{{ $template->preview_image }}" alt="{{ $template->name }}" class="w-full h-64 object-cover">
            @else
                <div class="w-full h-64 bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>
                </div>
            @endif

            <div class="p-8">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $template->name }}</h1>
                    <div class="flex items-center gap-3">
                        @if($template->is_premium)
                            <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">${{ number_format($template->price, 2) }}</span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">Free</span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400 mb-6">
                    <span>by {{ $template->author->name }}</span>
                    <span class="mx-2">·</span>
                    <span>v{{ $template->version }}</span>
                    @if($template->framework)
                        <span class="mx-2">·</span>
                        <span>{{ $template->framework }}</span>
                    @endif
                    <span class="mx-2">·</span>
                    <span>{{ $template->downloads_count }} downloads</span>
                    @if($template->rating)
                        <span class="mx-2">·</span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>
                            {{ number_format($template->rating, 1) }} ({{ $template->rating_count }} reviews)
                        </span>
                    @endif
                </div>

                <div class="prose dark:prose-invert max-w-none mb-8">
                    {!! $template->description !!}
                </div>

                <div class="flex gap-3 mb-8">
                    <a href="{{ $template->demo_url }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-700 text-sm font-medium rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                        Live Demo
                    </a>
                    <button wire:click="download" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                        Download
                    </button>
                </div>

                <div class="border-t border-zinc-200 dark:border-zinc-800 pt-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Reviews</h2>

                    @auth
                        <form wire:submit="addReview" class="mb-8 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-4">
                            <div class="flex items-center gap-4 mb-3">
                                <label class="text-sm font-medium text-gray-700 dark:text-zinc-300">Rating:</label>
                                <div class="flex gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none">
                                            <svg class="w-6 h-6 {{ $i <= $rating ? 'text-yellow-400' : 'text-zinc-300 dark:text-zinc-600' }} fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>
                                        </button>
                                    @endfor
                                </div>
                            </div>
                            <textarea wire:model="reviewBody" rows="3" placeholder="Write your review..."
                                      class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-y mb-3"></textarea>
                            @error('reviewBody') <p class="text-sm text-red-600 mb-2">{{ $message }}</p> @enderror
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Submit Review</button>
                        </form>
                    @else
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-8"><a href="{{ route('login') }}" class="text-purple-600 hover:underline">Login</a> to leave a review.</p>
                    @endauth

                    <div class="space-y-4">
                        @forelse($template->reviews as $review)
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-zinc-300 dark:text-zinc-600' }} fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->user->name }}</span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $review->body }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No reviews yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
