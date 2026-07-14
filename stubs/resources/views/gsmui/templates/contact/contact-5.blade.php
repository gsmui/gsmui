@props([
    'title' => __('Contact us'),
    'inquiryTypes' => [__('General inquiry'), __('Technical support'), __('Partnership'), __('Press')],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }} x-data="{ step: 1, type: '', name: '', email: '', message: '' }">
    <div class="mx-auto max-w-lg">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
            <div class="mt-6 flex items-center justify-center gap-2">
                @foreach ([1, 2, 3] as $s)
                    <div class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full text-sm font-medium" :class="step >= {{ $s }} ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-200 dark:bg-white/10 text-zinc-500'">{{ $s }}</div>
                        @if ($s < 3)
                            <div class="h-px w-10" :class="step > {{ $s }} ? 'bg-zinc-900 dark:bg-white' : 'bg-zinc-200 dark:bg-white/10'"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="rounded-2xl border border-zinc-200 dark:border-white/10 p-8">
            <div x-show="step === 1">
                <h3 class="mb-4 font-semibold text-zinc-900 dark:text-white">{{ __('What can we help with?') }}</h3>
                <div class="space-y-2">
                    @foreach ($inquiryTypes as $t)
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-zinc-200 dark:border-white/10 px-4 py-3 transition hover:bg-zinc-50 dark:hover:bg-white/5" :class="type === '{{ $t }}' && 'border-zinc-900 dark:border-white'">
                            <input type="radio" name="type" value="{{ $t }}" x-model="type" class="sr-only" />
                            <div class="h-4 w-4 rounded-full border-2" :class="type === '{{ $t }}' ? 'border-zinc-900 dark:border-white bg-zinc-900 dark:bg-white' : 'border-zinc-300 dark:border-zinc-600'"></div>
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $t }}</span>
                        </label>
                    @endforeach
                </div>
                <gsmui:button class="mt-6 w-full" @click="type && (step = 2)">{{ __('Continue') }}</gsmui:button>
            </div>
            <div x-show="step === 2">
                <h3 class="mb-4 font-semibold text-zinc-900 dark:text-white">{{ __('Your details') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Name') }}</label>
                        <gsmui:input x-model="name" class="mt-1 w-full" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Email') }}</label>
                        <gsmui:input type="email" x-model="email" class="mt-1 w-full" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Message') }}</label>
                        <textarea x-model="message" rows="4" class="mt-1 w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:outline-none"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <gsmui:button variant="outline" class="flex-1" @click="step = 1">{{ __('Back') }}</gsmui:button>
                    <gsmui:button class="flex-1" @click="name && email && (step = 3)">{{ __('Submit') }}</gsmui:button>
                </div>
            </div>
            <div x-show="step === 3" class="text-center py-8">
                <x-gsmui:icon name="check-circle" class="mx-auto h-12 w-12 text-green-500" />
                <h3 class="mt-4 text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Thank you!') }}</h3>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('We\'ve received your message and will get back to you within 24 hours.') }}</p>
            </div>
        </div>
    </div>
</section>
