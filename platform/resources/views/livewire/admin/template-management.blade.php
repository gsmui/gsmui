<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Templates</h1>
        <button wire:click="createTemplate" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700">Add Template</button>
    </div>
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <table class="w-full">
            <thead><tr class="border-b border-zinc-200 dark:border-zinc-800"><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Name</th><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Category</th><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Price</th><th class="px-6 py-3 text-right text-xs font-semibold text-zinc-500">Actions</th></tr></thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($templates as $template)
                    <tr><td class="px-6 py-4 text-sm font-medium">{{ $template->name }}</td><td class="px-6 py-4 text-sm text-zinc-500">{{ $template->category ?? '-' }}</td><td class="px-6 py-4 text-sm">{{ $template->is_free ? 'Free' : '$' . $template->price }}</td><td class="px-6 py-4 text-right"><button wire:click="editTemplate({{ $template->id }})" class="text-xs text-purple-600 hover:text-purple-700 mr-2">Edit</button><button wire:click="deleteTemplate({{ $template->id }})" wire:confirm="Delete?" class="text-xs text-red-600 hover:text-red-700">Delete</button></td></tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-sm text-zinc-500">No templates found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
