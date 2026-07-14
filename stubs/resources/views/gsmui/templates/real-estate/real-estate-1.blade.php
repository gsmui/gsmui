@props([
    'title' => 'Find Your Dream Home',
])

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    <section class="px-8 py-12 text-center">
        <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ __($title) }}</h2>
        <div class="mx-auto mt-6 flex max-w-xl items-center gap-2 rounded-full border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 px-4 py-2 shadow-sm">
            <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="{{ __('Search by city, zip, or address...') }}" class="flex-1 bg-transparent text-sm text-zinc-900 dark:text-white placeholder-zinc-400 outline-none" />
            <button class="rounded-full bg-zinc-900 dark:bg-white px-5 py-2 text-sm font-semibold text-white dark:text-zinc-900">{{ __('Search') }}</button>
        </div>
    </section>

    <div class="mx-auto max-w-6xl px-8">
        <div class="mb-8 flex flex-wrap gap-2">
            @foreach (['Under $300K', '$300K–$500K', '$500K–$750K', '$750K+', '3+ Beds', '2+ Baths', 'House', 'Condo'] as $filter)
                <button class="rounded-full border border-zinc-200 dark:border-white/10 px-4 py-1.5 text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">{{ __($filter) }}</button>
            @endforeach
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([['$425,000', '4 bed · 3 bath · 2,400 sqft'], ['$389,000', '3 bed · 2 bath · 1,800 sqft'], ['$675,000', '5 bed · 4 bath · 3,200 sqft'], ['$299,000', '2 bed · 2 bath · 1,200 sqft'], ['$549,000', '4 bed · 3 bath · 2,600 sqft'], ['$415,000', '3 bed · 2 bath · 1,950 sqft']] as [$price, $details])
                <div class="group overflow-hidden rounded-xl bg-white shadow-sm dark:bg-zinc-800">
                    <div class="aspect-video bg-zinc-200 dark:bg-zinc-700"></div>
                    <div class="p-4">
                        <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $price }}</p>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $details }}</p>
                        <p class="mt-1 text-xs text-zinc-400">123 {{ __('Maple St') }}, {{ __('Austin, TX') }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10 flex items-center justify-center gap-2">
            @foreach ([1, 2, 3, '...', 12] as $page)
                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-sm {{ $page === 1 ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-semibold' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">{{ $page }}</button>
            @endforeach
        </div>
    </div>
</div>
