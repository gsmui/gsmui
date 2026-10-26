<div>
    <div class="max-w-4xl">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Projects</h1>
            <button wire:click="createProject" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                New Project
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($projects as $project)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $project->name }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $project->description ?: 'No description' }}</p>
                        </div>
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $project->is_public ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}">
                            {{ $project->is_public ? 'Public' : 'Private' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                        <span>Updated {{ $project->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="editProject({{ $project->id }})" class="px-3 py-1.5 text-xs font-medium rounded-lg border border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 hover:border-purple-300 dark:hover:border-purple-700 transition-colors">Edit</button>
                        <button wire:click="deleteProject({{ $project->id }})" wire:confirm="Delete this project?" class="px-3 py-1.5 text-xs font-medium rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">Delete</button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-10 h-10 mx-auto text-zinc-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No projects yet. Create your first one!</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $projects->links() }}
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-xl w-full max-w-md p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ $isEditing ? 'Edit Project' : 'New Project' }}</h2>
                <form wire:submit="saveProject">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Name</label>
                            <input type="text" wire:model="form.name" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500" placeholder="My Project">
                            @error('form.name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Slug</label>
                            <input type="text" wire:model="form.slug" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500" placeholder="my-project">
                            @error('form.slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Description</label>
                            <textarea wire:model="form.description" rows="3" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-none"></textarea>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="form.is_public" class="rounded border-zinc-300 dark:border-zinc-700 text-purple-600 focus:ring-purple-500">
                                <span class="text-sm text-zinc-700 dark:text-zinc-300">Make this project public</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
