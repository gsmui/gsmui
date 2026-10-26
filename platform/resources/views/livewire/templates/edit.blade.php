<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Template</h1>
                <a href="{{ route('templates.show', $template->slug) }}" class="text-sm text-purple-600 hover:text-purple-700">View Template</a>
            </div>

            <form wire:submit="updateTemplate">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Template Name</label>
                        <input type="text" id="name" wire:model="name"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Slug</label>
                        <input type="text" id="slug" wire:model="slug"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
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
                                <option value="landing">Landing Page</option>
                                <option value="dashboard">Dashboard</option>
                                <option value="blog">Blog</option>
                                <option value="ecommerce">E-commerce</option>
                                <option value="portfolio">Portfolio</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Price ($)</label>
                            <input type="number" id="price" wire:model="price" step="0.01" min="0"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>

                    <div>
                        <label for="preview_image" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Preview Image URL</label>
                        <input type="url" id="preview_image" wire:model="preview_image"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div>
                        <label for="demo_url" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Demo URL</label>
                        <input type="url" id="demo_url" wire:model="demo_url"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div>
                        <label for="repository_url" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Repository URL</label>
                        <input type="url" id="repository_url" wire:model="repository_url"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div>
                        <label for="version" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Version</label>
                        <input type="text" id="version" wire:model="version"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="button" wire:click="deleteTemplate" wire:confirm="Are you sure you want to delete this template?"
                            class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">Delete Template</button>
                    <div class="flex gap-3">
                        <a href="{{ route('templates.show', $template->slug) }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</a>
                        <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
