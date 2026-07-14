@props([
    'title' => __('Discover and share amazing recipes'),
    'subtitle' => __('Over 100,000 recipes from home cooks and professional chefs around the world.'),
    'features' => [
        ['name' => __('Smart Search'), 'desc' => __('Find recipes by ingredients, dietary needs, cuisine, or cooking time.')],
        ['name' => __('Meal Planning'), 'desc' => __('Plan your week with drag-and-drop meal calendars and auto-generated shopping lists.')],
        ['name' => __('Step-by-Step Guides'), 'desc' => __('Follow along with timers, videos, and helpful tips at each step.')],
        ['name' => __('Nutrition Info'), 'desc' => __('Auto-calculated calories, macros, and allergen warnings for every recipe.')],
        ['name' => __('Share & Collect'), 'desc' => __('Save favorites, create collections, and share your own recipes with the community.')],
        ['name' => __('Offline Access'), 'desc' => __('Download recipes for offline use. Cook anywhere, even without signal.')],
    ],
    'rating' => 4.9,
    'downloads' => '2M+',
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand name="RecipeApp" href="/" />
            <gsmui:button variant="primary" size="sm" href="#">{{ __('Download') }}</gsmui:button>
        </div>
    </header>

    <section class="px-6 py-28 text-center">
        <div class="mx-auto max-w-3xl">
            <div class="flex items-center justify-center gap-2 mb-4">
                <div class="flex gap-0.5">
                    @for ($i = 0; $i < 5; $i++)
                        <gsmui:icon name="star" class="h-5 w-5 text-amber-400" variant="solid" />
                    @endfor
                </div>
                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400 tabular-nums">{{ $rating }}</span>
                <gsmui:badge color="amber" rounded>{{ $downloads }} {{ __('Downloads') }}</gsmui:badge>
            </div>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl lg:text-6xl">{{ $title }}</h1>
            <p class="mt-6 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
            <div class="mt-10">
                <gsmui:button variant="primary" href="#" size="default" icon="device-phone-mobile">{{ __('Download Free') }}</gsmui:button>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-zinc-50 dark:bg-white/5">
        <div class="mx-auto max-w-6xl">
            <div class="mb-16 text-center">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Everything a home chef needs') }}</h2>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $feature['name'] }}</h3>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-6 py-20">
        <div class="mx-auto max-w-5xl">
            <div class="mb-16 text-center">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ __('How it works') }}</h2>
            </div>
            <div class="grid gap-8 lg:grid-cols-3">
                @foreach ([
                    ['step' => '1', 'title' => __('Browse & Search'), 'desc' => __('Find the perfect recipe from our curated collection of 100,000+ dishes.')],
                    ['step' => '2', 'title' => __('Cook Along'), 'desc' => __('Follow step-by-step instructions with built-in timers and tips.')],
                    ['step' => '3', 'title' => __('Share & Review'), 'desc' => __('Rate recipes, leave tips, and share your culinary creations.')],
                ] as $item)
                    <div class="text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 text-xl font-bold">{{ $item['step'] }}</div>
                        <h3 class="mt-4 text-lg font-semibold text-zinc-900 dark:text-white">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-6 py-16 border-t border-zinc-200 dark:border-white/10">
        <div class="mx-auto max-w-5xl grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['quote' => __('The meal planning feature saves me hours every week!'), 'author' => 'Anna K', 'rating' => 5],
                ['quote' => __('Best recipe app. The search by ingredients is genius.'), 'author' => 'Tom H', 'rating' => 5],
                ['quote' => __('My kids love following the step-by-step cooking guides.'), 'author' => 'Sarah M', 'rating' => 5],
            ] as $review)
                <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6">
                    <div class="flex gap-0.5 mb-3">
                        @for ($i = 0; $i < $review['rating']; $i++)
                            <gsmui:icon name="star" class="h-4 w-4 text-amber-400" variant="solid" />
                        @endfor
                    </div>
                    <blockquote class="text-sm text-zinc-600 dark:text-zinc-400">"{{ $review['quote'] }}"</blockquote>
                    <p class="mt-3 text-sm font-semibold text-zinc-900 dark:text-white">{{ $review['author'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-white/10 px-6 py-12">
        <div class="mx-auto max-w-6xl flex flex-col items-center gap-6 sm:flex-row sm:justify-between">
            <gsmui:brand name="RecipeApp" href="/" />
            <p class="text-sm text-zinc-400">&copy; {{ date('Y') }} {{ __('RecipeApp. All rights reserved.') }}</p>
        </div>
    </footer>
</div>
