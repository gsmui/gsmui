<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Components</h1>
            @auth
                <a href="{{ route('components.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500">
                    Create Component
                </a>
            @endauth
        </div>

        <div class="mb-6 flex flex-wrap gap-4">
            <input type="text" wire:model.live="search" placeholder="Search components..."
                   class="flex-1 min-w-0 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <select wire:model.live="type" class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">All Types</option>
                <option value="free">Free</option>
                <option value="premium">Premium</option>
            </select>
        </div>

        @if($categories->count())
            <div class="mb-6 flex flex-wrap gap-2">
                @foreach($categories as $category)
                    <button wire:click="$set('category', '{{ $category->slug }}')"
                            class="px-3 py-1 rounded-full text-sm {{ $category === $category->slug ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($components as $component)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    @if($component->preview_image)
                        <img src="{{ $component->preview_image }}" alt="{{ $component->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-400">No preview</span>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('components.show', $component->slug) }}" class="hover:text-indigo-600">
                                    {{ $component->name }}
                                </a>
                            </h3>
                            @if($component->is_premium)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Premium</span>
                            @elseif($component->is_free)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Free</span>
                            @endif
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ Str::limit($component->description, 100) }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $component->category }}</span>
                            <span>{{ $component->downloads_count }} downloads</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">No components found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $components->links() }}
        </div>
    </div>
</div>
