@props([
    'name' => 'Morning Brew',
    'tagline' => 'Your neighborhood coffee house',
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <nav class="flex items-center justify-between px-8 py-4">
        <span class="text-xl font-bold text-zinc-900 dark:text-white">{{ $name }}</span>
        <div class="hidden gap-6 text-sm text-zinc-600 dark:text-zinc-400 md:flex">
            <a href="#menu">{{ __('Menu') }}</a>
            <a href="#specials">{{ __('Specials') }}</a>
            <a href="#hours">{{ __('Hours') }}</a>
        </div>
    </nav>

    <section class="px-8 py-20 text-center">
        <h2 class="text-4xl font-bold text-zinc-900 dark:text-white" style="font-family: Georgia, serif;">{{ $name }}</h2>
        <p class="mt-3 text-zinc-500 dark:text-zinc-400">{{ $tagline }}</p>
        <div class="mt-6 h-64 w-full max-w-lg mx-auto rounded-2xl bg-zinc-100 dark:bg-zinc-800"></div>
    </section>

    <section id="specials" class="mx-auto max-w-4xl px-8 py-8">
        <div class="rounded-xl bg-amber-50 dark:bg-amber-900/20 p-6 text-center">
            <p class="text-sm font-semibold text-amber-700 dark:text-amber-400">{{ __("Today's Special") }}</p>
            <p class="mt-1 text-lg font-bold text-zinc-900 dark:text-white">{{ __('Oat Milk Latte + Croissant — $7.50') }}</p>
        </div>
    </section>

    <section id="menu" class="mx-auto max-w-4xl px-8 py-12">
        <h3 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Menu') }}</h3>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach (['Coffee', 'Pastries', 'Lunch'] as $category)
                <div class="rounded-xl bg-zinc-50 p-6 dark:bg-zinc-800">
                    <h4 class="mb-4 text-lg font-semibold text-zinc-900 dark:text-white">{{ __($category) }}</h4>
                    <ul class="space-y-3 text-sm text-zinc-600 dark:text-zinc-400">
                        <li class="flex justify-between"><span>{{ __('Americano') }}</span><span class="font-semibold text-zinc-900 dark:text-white">$4</span></li>
                        <li class="flex justify-between"><span>{{ __('Cappuccino') }}</span><span class="font-semibold text-zinc-900 dark:text-white">$5</span></li>
                        <li class="flex justify-between"><span>{{ __('Flat White') }}</span><span class="font-semibold text-zinc-900 dark:text-white">$5.50</span></li>
                    </ul>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-8 py-12">
        <h3 class="mb-6 text-center text-xl font-bold text-zinc-900 dark:text-white">{{ __('Instagram Feed') }}</h3>
        <div class="grid grid-cols-4 gap-3">
            @for ($i = 0; $i < 4; $i++)
                <div class="aspect-square rounded-xl bg-zinc-100 dark:bg-zinc-800"></div>
            @endfor
        </div>
    </section>

    <footer id="hours" class="border-t border-zinc-200 dark:border-white/10 px-8 py-10 text-center text-sm text-zinc-500">
        <p>{{ __('Mon–Fri 6 AM – 8 PM · Sat–Sun 7 AM – 6 PM') }}</p>
        <p class="mt-1">789 Elm Street · hello@morningbrew.com</p>
    </footer>
</div>
