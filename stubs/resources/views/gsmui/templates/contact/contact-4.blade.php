@props([
    'title' => __('Let\'s connect'),
    'subtitle' => __('Drop us a line. We\'ll get back to you within hours.'),
    'contactInfo' => [
        ['icon' => 'envelope', 'value' => 'hello@example.com'],
        ['icon' => 'phone', 'value' => '+1 (555) 123-4567'],
        ['icon' => 'map-pin', 'value' => __('San Francisco, CA')],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-zinc-950 rounded-3xl') }}>
    <div class="mx-auto max-w-5xl">
        <div class="grid gap-12 lg:grid-cols-2">
            <div>
                <h2 class="text-3xl font-bold text-white">{{ $title }}</h2>
                <p class="mt-4 text-zinc-400">{{ $subtitle }}</p>
                <div class="mt-8 space-y-4">
                    @foreach ($contactInfo as $info)
                        <div class="flex items-center gap-3 text-sm text-zinc-300">
                            <x-gsmui:icon :name="$info['icon']" class="h-5 w-5 text-zinc-500" />
                            {{ $info['value'] }}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-zinc-300">{{ __('Name') }}</label>
                    <input type="text" class="mt-1 w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-zinc-500 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300">{{ __('Email') }}</label>
                    <input type="email" class="mt-1 w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-zinc-500 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300">{{ __('Message') }}</label>
                    <textarea rows="4" class="mt-1 w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder:text-zinc-500 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50"></textarea>
                </div>
                <gsmui:button class="w-full">{{ __('Send message') }}</gsmui:button>
            </div>
            </div>
        </div>
    </div>
</section>
