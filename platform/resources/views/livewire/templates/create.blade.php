<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Submit Template</h1>

            <form wire:submit="save">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Name</label>
                        <input type="text" id="name" wire:model="name"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="Template name">
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Slug</label>
                        <input type="text" id="slug" wire:model="slug"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="template-url-slug">
                        @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Description</label>
                        <textarea id="description" wire:model="description" rows="4"
                                  class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-y"
                                  placeholder="Describe your template"></textarea>
                        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="categoryId" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Category</label>
                        <select id="categoryId" wire:model="categoryId"
                                class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="framework" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Framework</label>
                            <input type="text" id="framework" wire:model="framework"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="e.g. Laravel, React">
                        </div>
                        <div>
                            <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Industry</label>
                            <input type="text" id="industry" wire:model="industry"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="e.g. SaaS, E-commerce">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="version" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Version</label>
                            <input type="text" id="version" wire:model="version"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Price</label>
                            <input type="number" id="price" wire:model="price" step="0.01" min="0"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="flex items-end gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="isFree" class="rounded border-zinc-300 text-purple-600 focus:ring-purple-500">
                                <span class="text-sm text-gray-700 dark:text-zinc-300">Free</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="isPremium" class="rounded border-zinc-300 text-purple-600 focus:ring-purple-500">
                                <span class="text-sm text-gray-700 dark:text-zinc-300">Premium</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="demoUrl" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Demo URL</label>
                        <input type="url" id="demoUrl" wire:model="demoUrl"
                               class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                               placeholder="https://demo.example.com">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                    <a href="{{ route('templates.index') }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Submit Template</button>
                </div>
            </form>
        </div>
    </div>
</div>
