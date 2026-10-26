<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Users</h1>
    </div>
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <table class="w-full">
            <thead><tr class="border-b border-zinc-200 dark:border-zinc-800"><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">User</th><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Role</th><th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500">Joined</th></tr></thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($users ?? [] as $user)
                    <tr><td class="px-6 py-4"><p class="text-sm font-medium">{{ $user->name }}</p><p class="text-xs text-zinc-500">{{ $user->email }}</p></td><td class="px-6 py-4"><span class="text-xs bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-full">{{ $user->hasRole('admin') ? 'Admin' : 'User' }}</span></td><td class="px-6 py-4 text-sm text-zinc-500">{{ $user->created_at->format('M d, Y') }}</td></tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-12 text-center text-sm text-zinc-500">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
