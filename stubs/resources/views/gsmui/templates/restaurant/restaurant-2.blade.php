@props([
    'name' => 'The Bistro',
    'tagline' => 'Comfort food, made fresh daily',
])

<div {{ $attributes->class('min-h-screen bg-amber-50 dark:bg-zinc-900') }}>
    <nav class="flex items-center justify-between px-8 py-4">
        <span class="text-xl font-bold text-zinc-900 dark:text-white">{{ $name }}</span>
        <div class="hidden gap-6 text-sm text-zinc-600 dark:text-zinc-400 md:flex">
            <a href="#specials">{{ __('Specials') }}</a>
            <a href="#menu">{{ __('Menu') }}</a>
            <a href="#gallery">{{ __('Gallery') }}</a>
            <a href="#contact">{{ __('Contact') }}</a>
        </div>
    </nav>

    <section class="px-8 py-16 text-center">
        <h2 class="text-4xl font-bold text-zinc-900 dark:text-white" style="font-family: Georgia, serif;">{{ $name }}</h2>
        <p class="mt-3 text-zinc-600 dark:text-zinc-400">{{ $tagline }}</p>
    </section>

    <section id="specials" class="mx-auto max-w-5xl px-8 py-12">
        <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __("Today's Specials") }}</h3>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([['name' => 'Grilled Salmon', 'price' => '$24', 'desc' => 'With lemon butter sauce'], ['name' => 'Pasta Primavera', 'price' => '$18', 'desc' => 'Seasonal vegetables'], ['name' => 'Berry Crumble', 'price' => '$12', 'desc' => 'With vanilla ice cream']] as $item)
                <div class="rounded-xl bg-white p-6 shadow-sm dark:bg-zinc-800">
                    <div class="h-32 rounded-lg bg-zinc-200 dark:bg-zinc-700"></div>
                    <h4 class="mt-4 font-semibold text-zinc-900 dark:text-white">{{ __($item['name']) }}</h4>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __($item['desc']) }}</p>
                    <span class="mt-2 inline-block font-bold text-amber-600 dark:text-amber-400">{{ $item['price'] }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section id="menu" class="mx-auto max-w-5xl px-8 py-12">
        <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Menu') }}</h3>
        <div class="grid gap-4 md:grid-cols-2">
            @foreach ([['Burger Classic', '$16'], ['Caesar Salad', '$14'], ['Fish & Chips', '$19'], ['Steak Frites', '$28'], ['Chicken Parmesan', '$22'], ['Veggie Wrap', '$13']] as [$dish, $price])
                <div class="flex items-center justify-between rounded-lg bg-white px-5 py-3 shadow-sm dark:bg-zinc-800">
                    <span class="text-zinc-900 dark:text-white">{{ __($dish) }}</span>
                    <span class="font-semibold text-amber-600 dark:text-amber-400">{{ $price }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section id="gallery" class="mx-auto max-w-5xl px-8 py-12">
        <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Gallery') }}</h3>
        <div class="grid grid-cols-3 gap-3">
            @for ($i = 0; $i < 6; $i++)
                <div class="aspect-square rounded-xl bg-zinc-200 dark:bg-zinc-700"></div>
            @endfor
        </div>
    </section>

    <footer id="contact" class="border-t border-zinc-200 dark:border-white/10 px-8 py-10 text-center text-sm text-zinc-500">
        <p>456 Main Street, Suite 2 · {{ __('Open daily 11 AM – 10 PM') }}</p>
        <p class="mt-2">info@thebistro.com · (555) 123-4567</p>
    </footer>
</div>
