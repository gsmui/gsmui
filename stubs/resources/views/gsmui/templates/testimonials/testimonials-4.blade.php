@props([
    'posts' => [
        ['handle' => '@sarahbuilds', 'name' => 'Sarah Chen', 'text' => __('Just switched to @product and wow — the speed difference is insane. Our CI pipeline went from 12min to 3min. 🚀'), 'likes' => '247', 'retweets' => '58'],
        ['handle' => '@devmarcus', 'name' => 'Marcus J', 'text' => __('Best decision our team made this quarter. The collaboration features alone are worth it. No more context switching between 5 tools.'), 'likes' => '183', 'retweets' => '41'],
        ['handle' => '@emily_codes', 'name' => 'Emily R', 'text' => __('The developer experience is *chef\'s kiss*. API docs are clean, SDKs are well-maintained, and the CLI is powerful. This is how dev tools should be built.'), 'likes' => '312', 'retweets' => '89'],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($posts as $post)
                <div class="rounded-2xl border border-zinc-200 dark:border-white/10 p-6">
                    <div class="flex items-center gap-3">
                        <gsmui:avatar :initials="substr($post['name'], 0, 2)" size="sm" />
                        <div>
                            <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $post['name'] }}</div>
                            <div class="text-xs text-zinc-500">{{ $post['handle'] }}</div>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-zinc-700 dark:text-zinc-300">{{ $post['text'] }}</p>
                    <div class="mt-4 flex items-center gap-6 text-xs text-zinc-400">
                        <span class="flex items-center gap-1">
                            <x-gsmui:icon name="heart" class="h-4 w-4" />
                            {{ $post['likes'] }}
                        </span>
                        <span class="flex items-center gap-1">
                            <x-gsmui:icon name="arrow-path" class="h-4 w-4" />
                            {{ $post['retweets'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
