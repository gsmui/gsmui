<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Product</h1>

            <form wire:submit="save">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Name</label>
                        <input type="text" id="name" wire:model="name"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Slug</label>
                        <input type="text" id="slug" wire:model="slug"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                        @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Description</label>
                        <textarea id="description" wire:model="description" rows="6"
                                  class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-y"></textarea>
                        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Type</label>
                            <select id="type" wire:model="type"
                                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                                <option value="component">Component</option>
                                <option value="template">Template</option>
                                <option value="tool">Tool</option>
                                <option value="service">Service</option>
                            </select>
                        </div>
                        <div>
                            <label for="version" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Version</label>
                            <input type="text" id="version" wire:model="version"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Price</label>
                            <input type="number" id="price" wire:model="price" step="0.01" min="0"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                            @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="salePrice" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Sale Price</label>
                            <input type="number" id="salePrice" wire:model="salePrice" step="0.01" min="0"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>

                    <div>
                        <label for="demoUrl" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Demo URL</label>
                        <input type="url" id="demoUrl" wire:model="demoUrl"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
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
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="status" value="archived" class="text-purple-600 focus:ring-purple-500">
                                <span class="text-sm text-gray-700 dark:text-zinc-300">Archived</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                    <button wire:click="delete" wire:confirm="Are you sure you want to delete this product?"
                            class="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                        Delete
                    </button>
                    <div class="flex gap-3">
                        <a href="{{ route('marketplace.show', $product->slug) }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</a>
                        <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
