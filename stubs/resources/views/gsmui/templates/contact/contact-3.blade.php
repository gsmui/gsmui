@props([
    'title' => __('Contact us'),
    'info' => [
        ['icon' => 'map-pin', 'label' => __('Address'), 'value' => __('123 Innovation Drive, San Francisco, CA 94107')],
        ['icon' => 'phone', 'label' => __('Phone'), 'value' => '+1 (555) 123-4567'],
        ['icon' => 'envelope', 'label' => __('Email'), 'value' => 'hello@example.com'],
        ['icon' => 'clock', 'label' => __('Hours'), 'value' => __('Mon-Fri, 9am-6pm PST')],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-5xl">
        <div class="grid gap-10 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <div class="rounded-2xl border border-zinc-200 dark:border-white/10 p-8">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">{{ $title }}</h2>
                    <div class="space-y-5">
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('First name') }}</label>
                                <gsmui:input class="mt-1 w-full" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Last name') }}</label>
                                <gsmui:input class="mt-1 w-full" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Email') }}</label>
                            <gsmui:input type="email" class="mt-1 w-full" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Message') }}</label>
                            <textarea rows="4" class="mt-1 w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:outline-none"></textarea>
                        </div>
                        <gsmui:button>{{ __('Send message') }}</gsmui:button>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <div class="space-y-6 rounded-2xl border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-white/5 p-8">
                    @foreach ($info as $item)
                        <div class="flex gap-4">
                            <x-gsmui:icon :name="$item['icon']" class="h-5 w-5 shrink-0 text-zinc-400" />
                            <div>
                                <div class="text-xs font-medium text-zinc-500 uppercase tracking-wider">{{ $item['label'] }}</div>
                                <div class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">{{ $item['value'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
