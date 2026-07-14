@props([
    'name' => 'La Maison',
    'tagline' => 'An exquisite fine dining experience',
])

<div {{ $attributes->class('min-h-screen bg-zinc-900 text-white') }}>
    <nav class="flex items-center justify-between px-8 py-4">
        <span class="text-xl font-semibold tracking-wider" style="font-family: Georgia, serif;">{{ $name }}</span>
        <div class="hidden gap-8 text-sm text-zinc-400 md:flex">
            <a href="#menu" class="hover:text-amber-400 transition-colors">{{ __('Menu') }}</a>
            <a href="#reserve" class="hover:text-amber-400 transition-colors">{{ __('Reservations') }}</a>
            <a href="#about" class="hover:text-amber-400 transition-colors">{{ __('About') }}</a>
        </div>
    </nav>

    <section class="relative flex h-96 items-center justify-center bg-gradient-to-b from-zinc-800 to-zinc-900">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-900/20 via-zinc-800/40 to-zinc-900/60"></div>
        <div class="relative text-center">
            <h2 class="text-5xl font-bold" style="font-family: Georgia, serif;">{{ $name }}</h2>
            <p class="mt-4 text-lg text-zinc-300">{{ $tagline }}</p>
            <a href="#reserve" class="mt-6 inline-block rounded-full border border-amber-500 px-8 py-3 text-sm text-amber-400 hover:bg-amber-500 hover:text-zinc-900 transition-all">{{ __('Reserve a Table') }}</a>
        </div>
    </section>

    <section id="menu" class="mx-auto max-w-4xl px-8 py-20">
        <h3 class="mb-12 text-center text-3xl font-bold" style="font-family: Georgia, serif;">{{ __('Our Menu') }}</h3>
        <div class="grid gap-16 md:grid-cols-3">
            @foreach (['Starters', 'Mains', 'Desserts'] as $category)
                <div>
                    <h4 class="mb-6 border-b border-amber-500/30 pb-2 text-lg text-amber-400" style="font-family: Georgia, serif;">{{ __($category) }}</h4>
                    <ul class="space-y-4 text-sm text-zinc-400">
                        <li><span class="text-white">{{ __('Truffle Risotto') }}</span><span class="float-right text-amber-400">$28</span></li>
                        <li><span class="text-white">{{ __('Wagyu Tartare') }}</span><span class="float-right text-amber-400">$34</span></li>
                        <li><span class="text-white">{{ __('Lobster Bisque') }}</span><span class="float-right text-amber-400">$22</span></li>
                    </ul>
                </div>
            @endforeach
        </div>
    </section>

    <footer class="border-t border-zinc-800 px-8 py-12 text-center text-sm text-zinc-500">
        <p>123 Gourmet Avenue, Downtown</p>
        <p class="mt-1">{{ __('Tue–Sun 5:30 PM – 11:00 PM') }}</p>
        <p class="mt-4 text-zinc-600">&copy; {{ date('Y') }} {{ $name }}. {{ __('All rights reserved.') }}</p>
    </footer>
</div>
