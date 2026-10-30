<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Create Post</h1>

            <form wire:submit="savePost">
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Title</label>
                        <input type="text" id="title" wire:model="title"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="Enter post title">
                        @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Slug</label>
                        <input type="text" id="slug" wire:model="slug"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="post-url-slug">
                        @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Category</label>
                        <select id="category_id" wire:model="category_id"
                                class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Content</label>
                        <textarea id="body" wire:model="body" rows="12"
                                  class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-y"
                                  placeholder="Write your post content (HTML supported)"></textarea>
                        @error('body') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Tags</label>
                        <input type="text" id="tags" wire:model="tags"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="Comma-separated tags">
                    </div>

                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Featured Image URL</label>
                        <input type="url" id="featured_image" wire:model="featured_image"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="https://example.com/image.jpg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Status</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="status" value="draft" class="text-purple-600 focus:ring-purple-500">
                                <span class="text-sm text-gray-700 dark:text-zinc-300">Draft</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="status" value="published" class="text-purple-600 focus:ring-purple-500">
                                <span class="text-sm text-gray-700 dark:text-zinc-300">Published</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                    <a href="{{ route('blog.index') }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Create Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
