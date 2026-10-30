<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Project</h1>
                <a href="{{ route('playground.show', $project->slug) }}" class="text-sm text-purple-600 hover:text-purple-700">Open Editor</a>
            </div>

            <form wire:submit="updateProject">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Project Name</label>
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
                        <textarea id="description" wire:model="description" rows="3"
                                  class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-y"></textarea>
                    </div>

                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Language</label>
                        <select id="language" wire:model="language"
                                class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                            <option value="javascript">JavaScript</option>
                            <option value="html">HTML</option>
                            <option value="css">CSS</option>
                            <option value="php">PHP</option>
                            <option value="python">Python</option>
                        </select>
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Code</label>
                        <textarea id="code" wire:model="code" rows="12"
                                  class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-zinc-900 text-zinc-100 text-sm font-mono focus:ring-purple-500 focus:border-purple-500 resize-y"
                                  spellcheck="false"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="button" wire:click="deleteProject" wire:confirm="Are you sure you want to delete this project?"
                            class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">Delete Project</button>
                    <div class="flex gap-3">
                        <a href="{{ route('playground.show', $project->slug) }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</a>
                        <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
