@props([
    'heading' => __('Introducing Product v2'),
    'subtitle' => __('Rebuilt from the ground up for the modern web.'),
    'features' => [__('40% faster performance'), __('New dark mode'), __('Real-time collaboration'), __('Advanced API')],
    'cta' => __('Learn more'),
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-5xl text-center">
        <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-5xl">{{ $heading }}</h1>
        <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
        <div class="mx-auto mt-10 max-w-lg rounded-2xl border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-white/5 p-4">
            <div class="aspect-square rounded-xl bg-zinc-200 dark:bg-white/10"></div>
        </div>
        <div class="mt-10 flex flex-wrap justify-center gap-x-8 gap-y-3">
            @foreach ($features as $feature)
                <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                    <x-gsmui:icon name="check-circle" class="h-5 w-5 text-green-500" />
                    {{ $feature }}
                </div>
            @endforeach
        </div>
        <gsmui:button class="mt-8" size="lg">{{ $cta }}</gsmui:button>
    </div>
</section>
