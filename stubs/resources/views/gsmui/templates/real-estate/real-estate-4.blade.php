@props([
    'title' => 'Your Home Journey Starts Here',
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <section class="px-8 py-20 text-center">
        <h2 class="text-4xl font-bold text-zinc-900 dark:text-white">{{ __($title) }}</h2>
        <p class="mx-auto mt-3 max-w-md text-zinc-500 dark:text-zinc-400">{{ __('Search millions of homes, apartments, and properties.') }}</p>
        <div class="mx-auto mt-8 flex max-w-xl items-center gap-2 rounded-full border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-800 px-4 py-3">
            <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="{{ __('Enter city, neighborhood, or ZIP') }}" class="flex-1 bg-transparent text-sm text-zinc-900 dark:text-white placeholder-zinc-400 outline-none" />
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-8 py-12">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([['Buy', 'Find your dream home'], ['Rent', 'Discover rental properties'], ['Sell', 'List your property']] as [$title, $desc])
                <div class="cursor-pointer rounded-2xl bg-zinc-50 p-8 text-center transition-all hover:shadow-md dark:bg-zinc-800">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-zinc-200 dark:bg-zinc-700">
                        <span class="text-2xl">{{ $loop->iteration === 1 ? '🏠' : ($loop->iteration === 2 ? '🔑' : '💰') }}</span>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-900 dark:text-white">{{ __($title) }}</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __($desc) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-8 py-12">
        <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Featured Properties') }}</h3>
        <div class="grid gap-6 md:grid-cols-2">
            @foreach ([['$425,000', '4 bed · 3 bath · 2,400 sqft', 'Austin, TX'], ['$675,000', '5 bed · 4 bath · 3,200 sqft', 'Denver, CO']] as [$price, $details, $location])
                <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-zinc-800">
                    <div class="aspect-video bg-zinc-200 dark:bg-zinc-700"></div>
                    <div class="p-5">
                        <p class="text-xl font-bold text-zinc-900 dark:text-white">{{ $price }}</p>
                        <p class="mt-1 text-sm text-zinc-500">{{ $details }}</p>
                        <p class="mt-1 text-xs text-zinc-400">{{ $location }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-8 py-12">
        <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Explore Neighborhoods') }}</h3>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @foreach (['Downtown', 'Suburbs', 'Waterfront', 'Historic'] as $area)
                <div class="cursor-pointer rounded-xl bg-zinc-100 p-6 text-center transition-all hover:shadow-md dark:bg-zinc-800">
                    <div class="h-20 rounded-lg bg-zinc-200 dark:bg-zinc-700"></div>
                    <p class="mt-3 text-sm font-semibold text-zinc-900 dark:text-white">{{ __($area) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-8 py-16 text-center">
        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ __('Stay Updated') }}</h3>
        <p class="mt-2 text-sm text-zinc-500">{{ __('Get new listings delivered to your inbox.') }}</p>
        <div class="mx-auto mt-4 flex max-w-md items-center gap-2">
            <input type="email" placeholder="{{ __('Enter your email') }}" class="flex-1 rounded-lg border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-2.5 text-sm outline-none" />
            <button class="rounded-lg bg-zinc-900 dark:bg-white px-6 py-2.5 text-sm font-semibold text-white dark:text-zinc-900">{{ __('Subscribe') }}</button>
        </div>
    </section>
</div>
