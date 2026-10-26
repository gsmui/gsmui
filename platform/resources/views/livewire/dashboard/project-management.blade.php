<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Projects</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4">
                <h3 class="font-semibold">{{ $project->name }}</h3>
                <p class="text-sm text-zinc-500 mt-1">{{ $project->description ?? 'No description' }}</p>
            </div>
        @empty
            <div class="col-span-full text-center py-12"><p class="text-zinc-500">No projects yet.</p></div>
        @endforelse
    </div>
</div>
