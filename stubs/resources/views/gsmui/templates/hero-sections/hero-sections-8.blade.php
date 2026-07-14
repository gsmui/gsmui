@props([
    'name' => __('Alex Rivera'),
    'title' => __('Full-Stack Developer & Designer'),
    'bio' => __('I build beautiful, performant web applications. Currently crafting developer tools at Acme Inc.'),
    'socials' => [
        ['icon' => 'globe-alt', 'label' => __('Website')],
        ['icon' => 'code-bracket', 'label' => __('GitHub')],
        ['icon' => 'at-symbol', 'label' => __('Email')],
    ],
])

<section {{ $attributes->class('py-24 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-2xl text-center">
        <gsmui:avatar :initials="substr($name, 0, 2)" size="xl" />
        <h1 class="mt-6 text-3xl font-bold text-zinc-900 dark:text-white">{{ $name }}</h1>
        <p class="mt-2 text-lg text-zinc-500 dark:text-zinc-400">{{ $title }}</p>
        <p class="mt-4 text-zinc-600 dark:text-zinc-300">{{ $bio }}</p>
        <div class="mt-6 flex items-center justify-center gap-4">
            @foreach ($socials as $social)
                <button class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 dark:border-white/10 text-zinc-500 dark:text-zinc-400 transition hover:bg-zinc-100 dark:hover:bg-white/10" aria-label="{{ $social['label'] }}">
                    <x-gsmui:icon :name="$social['icon']" class="h-5 w-5" />
                </button>
            @endforeach
        </div>
        <div class="mt-16 animate-bounce">
            <x-gsmui:icon name="chevron-down" class="mx-auto h-6 w-6 text-zinc-400" />
        </div>
    </div>
</section>
