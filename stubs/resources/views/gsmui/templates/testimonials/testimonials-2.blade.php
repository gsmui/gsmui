@props([
    'quote' => __('This platform didn\'t just change our tools — it changed how we think about building products. The impact was immediate and profound.'),
    'name' => 'David Kim',
    'role' => 'CEO, InnovateCo',
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-3xl text-center">
        <div class="relative">
            <x-gsmui:icon name="chat-bubble-left-right" class="mx-auto mb-8 h-12 w-12 text-zinc-200 dark:text-white/10" />
            <blockquote class="text-2xl font-medium leading-relaxed text-zinc-700 dark:text-zinc-200 lg:text-3xl">
                "{{ $quote }}"
            </blockquote>
        </div>
        <div class="mt-10 flex flex-col items-center gap-3">
            <gsmui:avatar :initials="substr($name, 0, 2)" size="lg" />
            <div>
                <div class="font-semibold text-zinc-900 dark:text-white">{{ $name }}</div>
                <div class="text-sm text-zinc-500">{{ $role }}</div>
            </div>
        </div>
    </div>
</section>
