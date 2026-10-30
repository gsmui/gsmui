<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
            <p class="text-sm text-zinc-500">Projects</p>
            <p class="text-2xl font-bold mt-1">{{ $projectCount }}</p>
        </div>
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
            <p class="text-sm text-zinc-500">Favorites</p>
            <p class="text-2xl font-bold mt-1">{{ $favoriteCount }}</p>
        </div>
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
            <p class="text-sm text-zinc-500">Downloads</p>
            <p class="text-2xl font-bold mt-1">{{ $downloadCount }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
        <h2 class="text-lg font-semibold mb-4">Recent Projects</h2>
        @forelse($recentProjects as $project)
            <div class="flex items-center gap-4 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 mb-2">
                <div class="w-12 h-12 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">📁</div>
                <div class="flex-1"><p class="text-sm font-medium">{{ $project->name }}</p><p class="text-xs text-zinc-500">{{ $project->description ?? 'No description' }}</p></div>
            </div>
        @empty
            <p class="text-sm text-zinc-500 text-center py-8">No projects yet. Create your first project!</p>
        @endforelse
    </div>
</div>
