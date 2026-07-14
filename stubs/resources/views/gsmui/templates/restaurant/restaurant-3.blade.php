@props([
    'name' => 'Noir Kitchen',
    'tagline' => 'Where culinary art meets darkness',
])

<div {{ $attributes->class('min-h-screen bg-zinc-950 text-white') }}>
    <nav class="flex items-center justify-between px-8 py-4">
        <span class="text-lg font-bold tracking-widest uppercase">{{ $name }}</span>
        <div class="hidden gap-6 text-xs uppercase tracking-wider text-zinc-500 md:flex">
            <a href="#gallery" class="hover:text-white transition-colors">{{ __('Gallery') }}</a>
            <a href="#menu" class="hover:text-white transition-colors">{{ __('Menu') }}</a>
            <a href="#reserve" class="hover:text-white transition-colors">{{ __('Reserve') }}</a>
        </div>
    </nav>

    <section class="relative h-80 bg-gradient-to-b from-zinc-800 to-zinc-950 flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-900/20 via-zinc-800/40 to-zinc-950/60"></div>
        <div class="relative text-center">
            <h2 class="text-5xl font-bold" style="font-family: Georgia, serif;">{{ $name }}</h2>
            <p class="mt-3 text-zinc-400">{{ $tagline }}</p>
        </div>
    </section>

    <section id="gallery" class="mx-auto max-w-6xl px-8 py-16">
        <h3 class="mb-8 text-center text-2xl font-semibold">{{ __('Gallery') }}</h3>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
            @for ($i = 0; $i < 6; $i++)
                <div class="aspect-[4/3] rounded-xl bg-zinc-800"></div>
            @endfor
        </div>
    </section>

    <section id="menu" class="mx-auto max-w-4xl px-8 py-16">
        <h3 class="mb-8 text-center text-2xl font-semibold">{{ __('Menu') }}</h3>
        <div class="mb-6 flex justify-center gap-4">
            @foreach (['Starters', 'Mains', 'Desserts'] as $tab)
                <button class="rounded-full border border-zinc-700 px-5 py-2 text-xs uppercase tracking-wider hover:border-white hover:text-white transition-all {{ $loop->first ? 'border-white text-white' : 'text-zinc-500' }}">{{ __($tab) }}</button>
            @endforeach
        </div>
        <div class="space-y-4">
            @foreach ([['Seared Foie Gras', '$32'], ['Black Truffle Pasta', '$38'], ['Dark Chocolate Fondant', '$16']] as [$dish, $price])
                <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
                    <span class="text-zinc-300">{{ __($dish) }}</span>
                    <span class="font-mono text-sm text-zinc-500">{{ $price }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section id="reserve" class="px-8 py-16 text-center">
        <h3 class="text-2xl font-semibold">{{ __('Reserve a Table') }}</h3>
        <p class="mt-2 text-sm text-zinc-500">{{ __('Experience the art of fine dining') }}</p>
        <button class="mt-6 rounded-full bg-white px-8 py-3 text-sm font-semibold text-zinc-900 hover:bg-zinc-200 transition-colors">{{ __('Book Now') }}</button>
    </section>

    <footer class="border-t border-zinc-800 px-8 py-8 text-center">
        <div class="flex justify-center gap-6 text-sm text-zinc-600">
            <a href="#" class="hover:text-white transition-colors">Instagram</a>
            <a href="#" class="hover:text-white transition-colors">Facebook</a>
            <a href="#" class="hover:text-white transition-colors">Twitter</a>
        </div>
        <p class="mt-4 text-xs text-zinc-700">&copy; {{ date('Y') }} {{ $name }}</p>
    </footer>
</div>
