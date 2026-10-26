<div class="max-w-2xl">
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Profile Information</h2>
        <form wire:submit="updateProfile" class="space-y-4">
            <div><label class="block text-sm font-medium mb-1">Name</label><input type="text" wire:model="name" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Username</label><input type="text" wire:model="username" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Email</label><input type="email" wire:model="email" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Bio</label><textarea wire:model="bio" rows="3" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm"></textarea></div>
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700">Save Changes</button>
        </form>
    </div>
</div>
