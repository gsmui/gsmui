@props([
    'project' => 'The Residences at Park Avenue',
    'tagline' => 'Luxury living redefined — Now accepting reservations',
])

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    <section class="relative flex h-96 items-center justify-center bg-gradient-to-r from-zinc-800 to-zinc-900">
        <div class="absolute inset-0 bg-gradient-to-br from-violet-900/20 via-zinc-800/40 to-zinc-900/60"></div>
        <div class="relative text-center text-white">
            <p class="text-xs uppercase tracking-widest text-zinc-400">{{ __('New Development') }}</p>
            <h2 class="mt-2 text-4xl font-bold">{{ __($project) }}</h2>
            <p class="mt-3 text-zinc-400">{{ __($tagline) }}</p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-8 py-16">
        <h3 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Floor Plans') }}</h3>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([['Studio', '550 sqft', '$350,000'], ['1 Bedroom', '850 sqft', '$525,000'], ['2 Bedroom', '1,200 sqft', '$750,000']] as [$type, $size, $price])
                <div class="rounded-xl bg-white p-6 text-center shadow-sm dark:bg-zinc-800">
                    <div class="aspect-square rounded-lg bg-zinc-100 dark:bg-zinc-700"></div>
                    <h4 class="mt-4 font-bold text-zinc-900 dark:text-white">{{ __($type) }}</h4>
                    <p class="text-sm text-zinc-500">{{ $size }}</p>
                    <p class="mt-2 text-lg font-bold text-zinc-900 dark:text-white">{{ __('From') }} {{ $price }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-8 py-16">
        <h3 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Amenities') }}</h3>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @foreach (['Rooftop Pool', 'Fitness Center', 'Concierge', 'Dog Park', 'Co-working', 'EV Charging', 'Theater', 'Spa'] as $amenity)
                <div class="rounded-xl bg-white p-4 text-center shadow-sm dark:bg-zinc-800">
                    <div class="mx-auto h-10 w-10 rounded-full bg-zinc-100 dark:bg-zinc-700"></div>
                    <p class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">{{ __($amenity) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-8 py-16">
        <h3 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Pricing') }}</h3>
        <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-zinc-800">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-700">
                    <tr><th class="px-6 py-3 text-left font-semibold text-zinc-900 dark:text-white">{{ __('Type') }}</th><th class="px-6 py-3 text-left font-semibold text-zinc-900 dark:text-white">{{ __('Size') }}</th><th class="px-6 py-3 text-right font-semibold text-zinc-900 dark:text-white">{{ __('Price') }}</th></tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @foreach ([['Studio', '550 sqft', '$350,000'], ['1 Bed', '850 sqft', '$525,000'], ['2 Bed', '1,200 sqft', '$750,000'], ['Penthouse', '2,400 sqft', '$1,500,000']] as [$type, $size, $price])
                        <tr><td class="px-6 py-3 text-zinc-900 dark:text-white">{{ __($type) }}</td><td class="px-6 py-3 text-zinc-500">{{ $size }}</td><td class="px-6 py-3 text-right font-semibold text-zinc-900 dark:text-white">{{ $price }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="mx-auto max-w-lg px-8 py-16 text-center">
        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ __('Register Your Interest') }}</h3>
        <form class="mt-6 space-y-4">
            <input type="text" placeholder="{{ __('Full name') }}" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-2.5 text-sm outline-none" />
            <input type="email" placeholder="{{ __('Email address') }}" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-2.5 text-sm outline-none" />
            <input type="tel" placeholder="{{ __('Phone number') }}" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-2.5 text-sm outline-none" />
            <button type="button" class="w-full rounded-lg bg-zinc-900 dark:bg-white px-6 py-2.5 text-sm font-semibold text-white dark:text-zinc-900">{{ __('Register Now') }}</button>
        </form>
    </section>
</div>
