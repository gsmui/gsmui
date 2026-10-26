<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Themes</h1>
            @auth
                <a href="{{ route('themes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500">
                    Create Theme
                </a>
            @endauth
        </div>

        <div class="mb-6 flex flex-wrap gap-4">
            <input type="text" wire:model.live="search" placeholder="Search themes..."
                   class="flex-1 min-w-0 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <select wire:model.live="type" class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">All Types</option>
                <option value="free">Free</option>
                <option value="premium">Premium</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($themes as $theme)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    @if($theme->preview_image)
                        <img src="{{ $theme->preview_image }}" alt="{{ $theme->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-400">No preview</span>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('themes.show', $theme->slug) }}" class="hover:text-indigo-600">
                                    {{ $theme->name }}
                                </a>
                            </h3>
                            @if($theme->is_premium)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Premium</span>
                            @elseif($theme->is_free)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Free</span>
                            @endif
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ Str::limit($theme->description, 100) }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                            <span>v{{ $theme->version }}</span>
                            <span>{{ $theme->downloads_count }} downloads</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">No themes found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $themes->links() }}
        </div>
    </div>
</div>
