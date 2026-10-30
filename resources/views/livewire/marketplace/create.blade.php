<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Submit Product</h1>

            <form wire:submit="saveProduct">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Product Name</label>
                        <input type="text" id="name" wire:model="name"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="My Awesome Product">
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Slug</label>
                        <input type="text" id="slug" wire:model="slug"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="my-awesome-product">
                        @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Description</label>
                        <textarea id="description" wire:model="description" rows="8"
                                  class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-y"
                                  placeholder="Describe your product (HTML supported)"></textarea>
                        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Type</label>
                            <select id="type" wire:model="type"
                                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                                <option value="component">Component</option>
                                <option value="plugin">Plugin</option>
                                <option value="theme">Theme</option>
                                <option value="template">Template</option>
                            </select>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Price ($)</label>
                            <input type="number" id="price" wire:model="price" step="0.01" min="0"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="0.00 for free">
                        </div>
                    </div>

                    <div>
                        <label for="preview_image" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Preview Image URL</label>
                        <input type="url" id="preview_image" wire:model="preview_image"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="https://example.com/preview.png">
                    </div>

                    <div>
                        <label for="repository_url" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Repository URL</label>
                        <input type="url" id="repository_url" wire:model="repository_url"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="https://github.com/user/repo">
                    </div>

                    <div>
                        <label for="version" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Version</label>
                        <input type="text" id="version" wire:model="version"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="1.0.0">
                        @error('version') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                    <a href="{{ route('marketplace.index') }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Submit Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
