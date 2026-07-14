@props([
    'title' => __('What our customers say'),
    'testimonials' => [
        ['quote' => __('This platform transformed how our team collaborates. We shipped 3x faster in the first quarter.'), 'name' => 'Sarah Chen', 'role' => 'CTO, TechFlow', 'stars' => 5],
        ['quote' => __('The best investment we made this year. ROI was clear within the first month of adoption.'), 'name' => 'Marcus Johnson', 'role' => 'VP Engineering, Scale.io', 'stars' => 5],
        ['quote' => __('Finally a tool that does what it promises. Clean interface, powerful features, great support.'), 'name' => 'Emily Rodriguez', 'role' => 'Product Lead, CraftCo', 'stars' => 5],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="grid gap-8 md:grid-cols-3">
            @foreach ($testimonials as $t)
                <div class="rounded-2xl border border-zinc-200 dark:border-white/10 p-6">
                    <div class="mb-4 flex gap-0.5">
                        @for ($i = 0; $i < $t['stars']; $i++)
                            <x-gsmui:icon name="star" class="h-4 w-4 fill-yellow-400 text-yellow-400" />
                        @endfor
                    </div>
                    <blockquote class="text-sm text-zinc-600 dark:text-zinc-300">"{{ $t['quote'] }}"</blockquote>
                    <div class="mt-6 flex items-center gap-3">
                        <gsmui:avatar :initials="substr($t['name'], 0, 2)" size="sm" />
                        <div>
                            <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $t['name'] }}</div>
                            <div class="text-xs text-zinc-500">{{ $t['role'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
