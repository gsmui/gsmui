<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                    @if($product->preview_image)
                        <img src="{{ $product->preview_image }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                    @endif

                    <div class="p-8">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>
                            @if($product->price > 0)
                                <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">${{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">Free</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 text-sm text-zinc-500 dark:text-zinc-400 mb-6">
                            <span>by {{ $product->author->name }}</span>
                            <span>v{{ $product->version }}</span>
                            <span>{{ $product->downloads_count }} downloads</span>
                            @if($product->rating)
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>
                                    {{ number_format($product->rating, 1) }} ({{ $product->reviews_count }} reviews)
                                </span>
                            @endif
                        </div>

                        <div class="prose dark:prose-invert max-w-none">
                            {!! $product->description !!}
                        </div>

                        @if($product->screenshots && count($product->screenshots))
                            <div class="mt-8">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Screenshots</h2>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach($product->screenshots as $screenshot)
                                        <img src="{{ $screenshot }}" alt="Screenshot {{ $loop->iteration }}" class="rounded-lg border border-zinc-200 dark:border-zinc-800">
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($product->changelog)
                            <div class="mt-8">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Changelog</h2>
                                <div class="prose dark:prose-invert max-w-none text-sm">{!! $product->changelog !!}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Reviews ({{ $product->reviews->count() }})</h2>
                    <div class="space-y-4">
                        @forelse($product->reviews as $review)
                            <div class="p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-800">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ substr($review->user->name, 0, 1) }}</div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->user->name }}</p>
                                        <div class="flex items-center gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-zinc-300 dark:text-zinc-600' }} fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400 ml-auto">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">No reviews yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
                    <button wire:click="purchase" class="w-full px-4 py-3 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors text-center">
                        {{ $product->price > 0 ? 'Purchase for $' . number_format($product->price, 2) : 'Download Free' }}
                    </button>

                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                            <span>Version</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $product->version }}</span>
                        </div>
                        <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                            <span>Last updated</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $product->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                            <span>Category</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $product->type }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Author</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-sm font-bold text-zinc-600 dark:text-zinc-300">{{ substr($product->author->name, 0, 1) }}</div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $product->author->name }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $product->author->products_count ?? 0 }} products</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
