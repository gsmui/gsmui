@props([
    'title' => __('Get in touch'),
    'subtitle' => __('We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.'),
    'address' => __('123 Innovation Drive, San Francisco, CA 94107'),
    'phone' => '+1 (555) 123-4567',
    'email' => 'hello@example.com',
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
            <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
        </div>
        <div class="grid gap-10 lg:grid-cols-2">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Name') }}</label>
                    <gsmui:input class="mt-1 w-full" placeholder="{{ __('Your name') }}" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Email') }}</label>
                    <gsmui:input type="email" class="mt-1 w-full" placeholder="{{ __('you@example.com') }}" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Message') }}</label>
                    <textarea rows="4" class="mt-1 w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:outline-none" placeholder="{{ __('How can we help?') }}"></textarea>
                </div>
                <gsmui:button>{{ __('Send message') }}</gsmui:button>
            </div>
            <div class="rounded-2xl bg-zinc-100 dark:bg-white/5 border border-zinc-200 dark:border-white/10 min-h-[400px]"></div>
        </div>
        <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:gap-10">
            <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                <x-gsmui:icon name="map-pin" class="h-5 w-5 text-zinc-400" />
                {{ $address }}
            </div>
            <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                <x-gsmui:icon name="phone" class="h-5 w-5 text-zinc-400" />
                {{ $phone }}
            </div>
            <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                <x-gsmui:icon name="envelope" class="h-5 w-5 text-zinc-400" />
                {{ $email }}
            </div>
        </div>
    </div>
</section>
