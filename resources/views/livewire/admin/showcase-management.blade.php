<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Showcase</h1>
        <select wire:model.live="status" class="rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm">
            <option value="all">All Status</option>
            <option value="pending">Pending</option>
            <option value="published">Published</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <table class="w-full">
            <thead><tr class="border-b border-zinc-200 dark:border-zinc-800"><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Title</th><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Status</th><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Author</th><th class="px-6 py-3 text-right text-xs font-semibold text-zinc-500">Actions</th></tr></thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($showcases as $showcase)
                    <tr><td class="px-6 py-4 text-sm font-medium">{{ $showcase->title }}</td><td class="px-6 py-4"><span class="text-xs px-2 py-1 rounded-full {{ $showcase->status === 'published' ? 'bg-green-100 text-green-700' : ($showcase->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">{{ ucfirst($showcase->status) }}</span></td><td class="px-6 py-4 text-sm text-zinc-500">{{ $showcase->author?->name ?? '-' }}</td><td class="px-6 py-4 text-right">@if($showcase->status === 'pending')<button wire:click="approveShowcase({{ $showcase->id }})" class="text-xs text-green-600 hover:text-green-700 mr-2">Approve</button><button wire:click="rejectShowcase({{ $showcase->id }})" class="text-xs text-yellow-600 hover:text-yellow-700 mr-2">Reject</button>@endif<button wire:click="deleteShowcase({{ $showcase->id }})" wire:confirm="Delete?" class="text-xs text-red-600 hover:text-red-700">Delete</button></td></tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-sm text-zinc-500">No showcases found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
