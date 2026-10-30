<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Marketplace</h1>
            @auth
                <a href="{{ route('marketplace.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                    Submit Product
                </a>
            @endauth
        </div>

        <div class="mb-6 flex flex-wrap gap-4">
            <input type="text" wire:model.live="search" placeholder="Search products..."
                   class="flex-1 min-w-0 rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
            <select wire:model.live="type"
                    class="rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                <option value="">All Types</option>
                <option value="free">Free</option>
                <option value="premium">Premium</option>
                <option value="plugin">Plugin</option>
                <option value="theme">Theme</option>
                <option value="component">Component</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden hover:shadow-lg transition-shadow">
                    @if($product->preview_image)
                        <img src="{{ $product->preview_image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                <a href="{{ route('marketplace.show', $product->slug) }}" class="hover:text-purple-600 transition-colors">{{ $product->name }}</a>
                            </h3>
                            @if($product->price > 0)
                                <span class="text-lg font-bold text-purple-600 dark:text-purple-400">${{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">Free</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($product->description, 100) }}</p>
                        <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                            <span>by {{ $product->author->name }}</span>
                            <div class="flex items-center gap-3">
                                <span>{{ $product->downloads_count }} downloads</span>
                                @if($product->rating)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>
                                        {{ number_format($product->rating, 1) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No products found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
