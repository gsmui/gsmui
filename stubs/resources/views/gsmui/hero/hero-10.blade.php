@props([
    'buttons' => [
        ['label' => 'Read Exclusive Blog', 'href' => '#', 'style' => 'primary'],
    ],
    'posts' => [
        ['category' => 'Design', 'categoryColor' => 'blue', 'title' => 'Boost your design workflow with Gsmui Pro', 'desc' => 'Learn how to streamline your design process with our powerful component library.', 'date' => 'August 21, 2024'],
        ['category' => 'Development', 'categoryColor' => 'violet', 'title' => 'The future of component libraries with Gsmui Pro', 'desc' => 'Exploring the next generation of UI development tools and frameworks.', 'date' => 'August 19, 2024'],
        ['category' => 'UX/UI', 'categoryColor' => 'emerald', 'title' => 'How Gsmui Pro enhances UI/UX design', 'desc' => 'A deep dive into creating better user experiences with our components.', 'date' => 'August 18, 2024'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div>
                <div class="mb-6 flex size-14 items-center justify-center rounded-2xl bg-amber-100 dark:bg-amber-900/30">
                    <span class="text-2xl" aria-hidden="true">⚡️</span>
                </div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                    Accelerate Your Design<br>with <span class="text-blue-600 dark:text-blue-400">Gsmui Pro</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                    Discover how Gsmui Pro empowers developers to build stunning, high-performance websites effortlessly.
                </p>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-blue-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-all duration-200">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="space-y-6">
                @foreach ($posts as $post)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6">
                        <span class="text-xs font-medium uppercase tracking-wider text-{{ $post['categoryColor'] }}-600 dark:text-{{ $post['categoryColor'] }}-400">{{ $post['category'] }}</span>
                        <h3 class="mt-2 font-semibold text-zinc-900 dark:text-white">{{ $post['title'] }}</h3>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $post['desc'] }}</p>
                        <p class="mt-3 text-xs text-zinc-400 dark:text-zinc-500">{{ $post['date'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
