<x-layouts.marketing>
    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4">
            <h1 class="text-4xl font-bold text-center text-zinc-900 dark:text-white mb-12">Components</h1>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($components as $component)
                    <a href="{{ route('components.show', $component) }}" class="rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 hover:border-purple-500 hover:shadow-lg transition-all">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $component->name }}</h3>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $component->description }}</p>
                        <div class="mt-4 flex items-center gap-4 text-xs text-zinc-500">
                            <span>v{{ $component->version }}</span>
                            <span>{{ number_format($component->downloads_count) }} downloads</span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12"><p class="text-zinc-500">No components available yet.</p></div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.marketing>
