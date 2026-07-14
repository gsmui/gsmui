@props([
    'buttons' => [
        ['label' => 'Join Now', 'href' => '#', 'style' => 'primary'],
    ],
    'posts' => [
        ['categoryColor' => 'cyan', 'title' => 'Design Smarter, Not Harder: Tips for Developers', 'desc' => 'Discover how Gsmui Pro can streamline your development process with intuitive components.'],
        ['categoryColor' => 'blue', 'title' => 'Design Smarter, Not Harder: Tips for Developers', 'desc' => 'Discover how Gsmui Pro can streamline your development process with intuitive components.'],
        ['categoryColor' => 'indigo', 'title' => 'Design Smarter, Not Harder: Tips for Developers', 'desc' => 'Discover how Gsmui Pro can streamline your development process with intuitive components.'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center mb-16">
            <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-cyan-100 dark:bg-cyan-900/30 px-4 py-1.5 text-sm font-medium text-cyan-700 dark:text-cyan-300"><span aria-hidden="true">🔥</span> Community of Developers</div>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl"><span class="text-2xl" aria-hidden="true">⚡</span> Built by the Community, <span class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">for the Community</span></h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400 mx-auto max-w-2xl">At Gsmui Pro, we believe in crafting beautiful, intuitive UI components that make development faster and more enjoyable.</p>
            <div class="mt-8 flex items-center justify-center gap-3"><span class="text-sm text-zinc-500 dark:text-zinc-400">Join us for free weekly updates and insights</span>
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}" class="rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-cyan-500 transition-all">{{ $button['label'] }}</a>
                @endforeach
            </div>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6">
                    <span class="text-xs font-medium uppercase tracking-wider text-{{ $post['categoryColor'] }}-600 dark:text-{{ $post['categoryColor'] }}-400">Innovation · 7 Mins Read</span>
                    <h3 class="mt-3 font-semibold text-zinc-900 dark:text-white">{{ $post['title'] }}</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $post['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
