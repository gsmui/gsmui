@props([
    'name' => 'Street Bites',
    'tagline' => 'Bold flavors on wheels',
])

{{--
    NOTE: This template uses raw Tailwind classes.
    Replace placeholder images/colors with your own assets.
--}}

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <nav class="flex items-center justify-between px-6 py-4">
        <span class="text-xl font-black uppercase tracking-wider text-orange-600">{{ $name }}</span>
        <div class="hidden gap-4 text-sm text-zinc-600 dark:text-zinc-400 md:flex">
            <a href="#menu">{{ __('Menu') }}</a>
            <a href="#location">{{ __('Find Us') }}</a>
            <a href="#catering">{{ __('Catering') }}</a>
        </div>
    </nav>

    <section class="bg-gradient-to-r from-orange-500 to-red-500 px-8 py-20 text-center text-white">
        <h2 class="text-5xl font-black uppercase" style="font-family: Impact, sans-serif;">{{ $name }}</h2>
        <p class="mt-3 text-lg text-orange-100">{{ $tagline }}</p>
        <a href="#menu" class="mt-6 inline-block rounded-full bg-white px-8 py-3 text-sm font-bold text-orange-600 hover:bg-orange-50 transition-colors">{{ __('See the Menu') }}</a>
    </section>

    <section id="menu" class="mx-auto max-w-5xl px-8 py-16">
        <h3 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Menu') }}</h3>
        <div class="grid gap-6 md:grid-cols-2">
            @foreach ([['Smash Burger', '$12', 'Double patty, secret sauce'], ['Loaded Fries', '$9', 'Cheese, jalapeño, bacon'], ['Tacos al Pastor', '$10', '3 tacos, pineapple salsa'], ['BBQ Pulled Pork', '$14', 'Brioche bun, coleslaw'], ['Chicken Wings', '$11', 'Buffalo or honey garlic'], ['Veggie Wrap', '$10', 'Grilled halloumi, hummus']] as [$name, $price, $desc])
                <div class="flex gap-4 rounded-xl bg-zinc-50 p-4 dark:bg-zinc-800">
                    <div class="h-20 w-20 flex-shrink-0 rounded-lg bg-zinc-200 dark:bg-zinc-700"></div>
                    <div>
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-zinc-900 dark:text-white">{{ __($name) }}</h4>
                            <span class="font-black text-orange-500">{{ $price }}</span>
                        </div>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __($desc) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="location" class="bg-orange-50 dark:bg-orange-900/10 px-8 py-12 text-center">
        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ __("Today's Location") }}</h3>
        <p class="mt-2 text-zinc-600 dark:text-zinc-400">{{ __('Downtown Food Park — 5th & Main') }}</p>
        <p class="text-sm text-zinc-500">{{ __('11 AM – 8 PM') }}</p>
        <div class="mx-auto mt-4 h-40 max-w-md rounded-xl bg-zinc-200 dark:bg-zinc-700"></div>
    </section>

    <section id="catering" class="px-8 py-16 text-center">
        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Book Us for Catering') }}</h3>
        <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ __('Events, parties, corporate lunches — we bring the flavor.') }}</p>
        <button class="mt-6 rounded-full bg-orange-500 px-8 py-3 text-sm font-bold text-white hover:bg-orange-600 transition-colors">{{ __('Get a Quote') }}</button>
    </section>

    <footer class="border-t border-zinc-200 dark:border-white/10 px-8 py-8 text-center">
        <div class="flex justify-center gap-5 text-sm text-zinc-500">
            <a href="#" class="hover:text-orange-500 transition-colors">Instagram</a>
            <a href="#" class="hover:text-orange-500 transition-colors">TikTok</a>
            <a href="#" class="hover:text-orange-500 transition-colors">Twitter</a>
        </div>
    </footer>
</div>
