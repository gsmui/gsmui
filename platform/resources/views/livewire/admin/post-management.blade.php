<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Blog Posts</h1>
        <button wire:click="createPost" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700">Add Post</button>
    </div>
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <table class="w-full">
            <thead><tr class="border-b border-zinc-200 dark:border-zinc-800"><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Title</th><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Status</th><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Date</th><th class="px-6 py-3 text-right text-xs font-semibold text-zinc-500">Actions</th></tr></thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($posts as $post)
                    <tr><td class="px-6 py-4 text-sm font-medium">{{ $post->title }}</td><td class="px-6 py-4"><span class="text-xs px-2 py-1 rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-zinc-100 text-zinc-700' }}">{{ ucfirst($post->status) }}</span></td><td class="px-6 py-4 text-sm text-zinc-500">{{ $post->created_at->format('M d, Y') }}</td><td class="px-6 py-4 text-right"><button wire:click="editPost({{ $post->id }})" class="text-xs text-purple-600 hover:text-purple-700 mr-2">Edit</button><button wire:click="deletePost({{ $post->id }})" wire:confirm="Delete?" class="text-xs text-red-600 hover:text-red-700">Delete</button></td></tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-sm text-zinc-500">No posts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
