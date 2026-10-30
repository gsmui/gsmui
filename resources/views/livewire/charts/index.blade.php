<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Charts</h1>
            @auth
                <a href="{{ route('charts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                    Create Chart
                </a>
            @endauth
        </div>

        <div class="mb-6 flex flex-wrap gap-4">
            <input type="text" wire:model.live="search" placeholder="Search charts..."
                   class="flex-1 min-w-0 rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
            <select wire:model.live="type"
                    class="rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                <option value="">All Types</option>
                <option value="bar">Bar</option>
                <option value="line">Line</option>
                <option value="pie">Pie</option>
                <option value="doughnut">Doughnut</option>
                <option value="area">Area</option>
                <option value="radar">Radar</option>
                <option value="scatter">Scatter</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($charts as $chart)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                <a href="{{ route('charts.show', $chart->slug) }}" class="hover:text-purple-600 transition-colors">{{ $chart->name }}</a>
                            </h3>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300">{{ ucfirst($chart->type) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                            <span>by {{ $chart->user->name }}</span>
                            <span>{{ $chart->views_count }} views</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No charts found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $charts->links() }}
        </div>
    </div>
</div>
