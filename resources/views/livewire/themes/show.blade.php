<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            @if($theme->preview_image)
                <img src="{{ $theme->preview_image }}" alt="{{ $theme->name }}" class="w-full h-64 object-cover">
            @else
                <div class="w-full h-64 bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                </div>
            @endif

            <div class="p-8">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $theme->name }}</h1>
                    <div class="flex items-center gap-3">
                        @if($theme->is_premium)
                            <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">${{ number_format($theme->price, 2) }}</span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">Free</span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center text-sm text-zinc-500 dark:text-zinc-400 mb-6">
                    <span>by {{ $theme->author->name }}</span>
                    <span class="mx-2">·</span>
                    <span>v{{ $theme->version }}</span>
                    <span class="mx-2">·</span>
                    <span>{{ $theme->downloads_count }} downloads</span>
                    @if($theme->rating)
                        <span class="mx-2">·</span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>
                            {{ number_format($theme->rating, 1) }}
                        </span>
                    @endif
                </div>

                <div class="prose dark:prose-invert max-w-none mb-8">
                    {!! $theme->description !!}
                </div>

                @if($theme->variations->count())
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Variations</h2>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($theme->variations as $variation)
                                <button wire:click="selectVariation({{ $variation->id }})"
                                        class="p-4 rounded-lg border-2 transition-colors {{ $selectedVariation == $variation->id ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20' : 'border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600' }}">
                                    <div class="w-full h-24 rounded bg-gradient-to-br {{ $variation->color_from }} to-{{ $variation->color_to }} mb-2"></div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $variation->name }}</p>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex gap-3">
                    <button wire:click="recordDownload" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                        Download Theme
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
