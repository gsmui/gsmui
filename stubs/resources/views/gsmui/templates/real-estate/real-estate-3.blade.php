@props([
    'agent' => [
        'name' => 'Sarah Johnson',
        'title' => 'Senior Real Estate Agent',
        'phone' => '(555) 987-6543',
        'email' => 'sarah@realty.com',
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-6xl px-8 py-12">
        <div class="grid gap-10 md:grid-cols-3">
            <div class="md:col-span-1">
                <div class="sticky top-24 rounded-2xl bg-white p-6 shadow-sm dark:bg-zinc-800">
                    <div class="mx-auto h-28 w-28 rounded-full bg-zinc-200 dark:bg-zinc-700"></div>
                    <h3 class="mt-4 text-center text-lg font-bold text-zinc-900 dark:text-white">{{ $agent['name'] }}</h3>
                    <p class="text-center text-sm text-zinc-500">{{ __($agent['title']) }}</p>
                    <div class="mt-4 space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                        <p>📞 {{ $agent['phone'] }}</p>
                        <p>✉️ {{ $agent['email'] }}</p>
                    </div>
                    <button class="mt-4 w-full rounded-lg bg-zinc-900 dark:bg-white px-4 py-2.5 text-sm font-semibold text-white dark:text-zinc-900">{{ __('Contact Agent') }}</button>
                    <div class="mt-4 grid grid-cols-3 gap-2 text-center text-xs">
                        <div><p class="text-lg font-bold text-zinc-900 dark:text-white">150+</p><p class="text-zinc-500">{{ __('Sold') }}</p></div>
                        <div><p class="text-lg font-bold text-zinc-900 dark:text-white">12</p><p class="text-zinc-500">{{ __('Years') }}</p></div>
                        <div><p class="text-lg font-bold text-zinc-900 dark:text-white">4.9</p><p class="text-zinc-500">{{ __('Rating') }}</p></div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <h2 class="mb-6 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Active Listings') }}</h2>
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ([['$425,000', '4 bed · 3 bath'], ['$389,000', '3 bed · 2 bath'], ['$675,000', '5 bed · 4 bath'], ['$299,000', '2 bed · 2 bath']] as [$price, $details])
                        <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-zinc-800">
                            <div class="aspect-video bg-zinc-200 dark:bg-zinc-700"></div>
                            <div class="p-4">
                                <p class="font-bold text-zinc-900 dark:text-white">{{ $price }}</p>
                                <p class="text-sm text-zinc-500">{{ $details }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <h2 class="mb-6 mt-12 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Testimonials') }}</h2>
                <div class="space-y-4">
                    @foreach ([['"Sarah made our home buying process seamless!"', '— Mike & Lisa'], ['"Professional, knowledgeable, and always available."', '— James R.']] as [$quote, $author])
                        <div class="rounded-xl bg-white p-5 shadow-sm dark:bg-zinc-800">
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __($quote) }}</p>
                            <p class="mt-2 text-xs font-semibold text-zinc-900 dark:text-white">{{ $author }}</p>
                        </div>
                    @endforeach
                </div>

                <h2 class="mb-6 mt-12 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Send a Message') }}</h2>
                <form class="space-y-4 rounded-xl bg-white p-6 shadow-sm dark:bg-zinc-800">
                    <input type="text" placeholder="{{ __('Your name') }}" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-2.5 text-sm outline-none" />
                    <input type="email" placeholder="{{ __('Email address') }}" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-2.5 text-sm outline-none" />
                    <textarea rows="3" placeholder="{{ __('Message') }}" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-2.5 text-sm outline-none"></textarea>
                    <button type="button" class="rounded-lg bg-zinc-900 dark:bg-white px-6 py-2.5 text-sm font-semibold text-white dark:text-zinc-900">{{ __('Send') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
