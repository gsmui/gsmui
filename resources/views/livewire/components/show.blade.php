<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            @if($component->preview_image)
                <img src="{{ $component->preview_image }}" alt="{{ $component->name }}" class="w-full h-64 object-cover">
            @endif

            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $component->name }}</h1>
                    <div class="flex items-center space-x-4">
                        @auth
                            <button wire:click="toggleFavorite" class="text-gray-400 hover:text-red-500">
                                @if($isFavorited)
                                    <svg class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                @endif
                            </button>
                        @endauth
                        @if($component->is_premium)
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Premium</span>
                        @else
                            <a href="{{ route('components.show', $component->slug) }}" wire:click="recordDownload"
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500">
                                Download
                            </a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mb-6">
                    <span>by {{ $component->author->name }}</span>
                    <span>•</span>
                    <span>{{ $component->category }}</span>
                    <span>•</span>
                    <span>v{{ $component->version }}</span>
                    <span>•</span>
                    <span>{{ $component->downloads_count }} downloads</span>
                </div>

                <div class="prose dark:prose-invert max-w-none mb-8">
                    {!! $component->description !!}
                </div>

                @if($component->code_example)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Code Example</h2>
                        <pre class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto"><code>{{ $component->code_example }}</code></pre>
                    </div>
                @endif

                @if($component->installation_guide)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Installation</h2>
                        <div class="prose dark:prose-invert max-w-none">{!! $component->installation_guide !!}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
