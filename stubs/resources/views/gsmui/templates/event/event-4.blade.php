@props([
    'title' => 'A Celebration of Love',
    'couple_names' => 'Emma & Oliver',
    'date' => 'June 20, 2026',
    'venue' => 'Rosewood Gardens, Napa Valley',
    'schedule' => [
        ['time' => '3:00 PM', 'event' => 'Ceremony'],
        ['time' => '4:00 PM', 'event' => 'Cocktail Hour'],
        ['time' => '5:30 PM', 'event' => 'Reception & Dinner'],
        ['time' => '7:00 PM', 'event' => 'First Dance'],
        ['time' => '8:00 PM', 'event' => 'Dancing & Celebration'],
    ],
    'rsvp_url' => '#',
])

<div {{ $attributes->class(['min-h-screen bg-gradient-to-b from-rose-50 to-white dark:from-zinc-900 dark:to-zinc-950']) }}>
    <section class="max-w-3xl mx-auto px-4 py-20 text-center">
        <gsmui:text variant="subtle" size="sm" class="tracking-[0.3em] uppercase text-rose-400">{{ __('Together with their families') }}</gsmui:text>
        <div class="mt-8">
            <gsmui:heading size="xl" level="1" class="text-rose-900 dark:text-rose-200">{{ $couple_names }}</gsmui:heading>
        </div>
        <gsmui:text variant="subtle" size="lg" class="mt-4 text-rose-600 dark:text-rose-300">{{ $title }}</gsmui:text>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <gsmui:badge color="rose" rounded>{{ $date }}</gsmui:badge>
            <gsmui:badge color="pink" rounded>{{ $venue }}</gsmui:badge>
        </div>
        <div class="mt-10">
            <gsmui:button variant="primary" size="default" href="{{ $rsvp_url }}" class="bg-rose-500 hover:bg-rose-600">{{ __('RSVP') }}</gsmui:button>
        </div>
    </section>

    <gsmui:divider text="&#10047;" color="secondary" />

    <section class="max-w-3xl mx-auto px-4 py-12 text-center">
        <gsmui:heading size="default" level="3" class="text-rose-900 dark:text-rose-200">{{ __('Our Story') }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-4 max-w-lg mx-auto text-rose-600 dark:text-rose-300">{{ __('We met on a rainy afternoon at a small bookshop in the city. Five years, countless adventures, and one very patient cat later — we\'re ready to say "I do."') }}</gsmui:text>
    </section>

    <section class="max-w-3xl mx-auto px-4 py-16">
        <gsmui:heading size="lg" level="2" class="text-center text-rose-900 dark:text-rose-200 mb-10">{{ __('Schedule of Events') }}</gsmui:heading>
        <div class="relative">
            <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-px bg-rose-200 dark:bg-rose-800"></div>
            @foreach($schedule as $index => $item)
                <div class="relative flex items-center mb-8 {{ $index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                    <div class="hidden md:block w-1/2 {{ $index % 2 === 0 ? 'text-right pr-8' : 'text-left pl-8' }}">
                        <gsmui:text variant="subtle" size="sm" class="text-rose-400">{{ $item['time'] }}</gsmui:text>
                        <gsmui:text variant="strong" class="text-rose-900 dark:text-rose-200">{{ $item['event'] }}</gsmui:text>
                    </div>
                    <div class="absolute left-4 md:left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-rose-400 border-2 border-white dark:border-zinc-900 z-10"></div>
                    <div class="ml-10 md:hidden">
                        <gsmui:text variant="subtle" size="sm" class="text-rose-400">{{ $item['time'] }}</gsmui:text>
                        <gsmui:text variant="strong" class="text-rose-900 dark:text-rose-200">{{ $item['event'] }}</gsmui:text>
                    </div>
                    <div class="hidden md:block w-1/2"></div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-rose-50 dark:bg-rose-900/10 py-16">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <gsmui:heading size="lg" level="2" class="text-rose-900 dark:text-rose-200 mb-6">{{ __('Gallery') }}</gsmui:heading>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @for($i = 0; $i < 6; $i++)
                    <div class="aspect-square bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center">
                        <gsmui:icon name="photo" variant="outline" class="w-8 h-8 text-rose-300 dark:text-rose-600" />
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-4 py-12 text-center">
        <gsmui:heading size="default" level="3" class="text-rose-900 dark:text-rose-200">{{ __('Gift Registry') }}</gsmui:heading>
        <gsmui:text variant="subtle" size="sm" class="mt-2 text-rose-600 dark:text-rose-300">{{ __('Your presence is the greatest gift. If you wish to honor us further:') }}</gsmui:text>
        <div class="mt-4 flex justify-center gap-3">
            @foreach(['Crate & Barrel', 'Amazon', 'Honeymoon Fund'] as $registry)
                <gsmui:badge color="rose" rounded>{{ $registry }}</gsmui:badge>
            @endforeach
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-4 py-16 text-center">
        <gsmui:heading size="default" level="2" class="text-rose-900 dark:text-rose-200">{{ __('Join Us in Celebrating') }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-2 text-rose-600 dark:text-rose-300">{{ __('We can\'t wait to share this special day with you.') }}</gsmui:text>
        <gsmui:button variant="primary" size="default" href="{{ $rsvp_url }}" class="mt-6 bg-rose-500 hover:bg-rose-600">{{ __('RSVP Now') }}</gsmui:button>
    </section>

    <footer class="border-t border-rose-200 dark:border-rose-800/30 py-8">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm" class="text-rose-400">{{ $couple_names }} &middot; {{ $date }} &middot; {{ $venue }}</gsmui:text>
        </div>
    </footer>
</div>
