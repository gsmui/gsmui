@props([
    'heading' => __('Join the waitlist'),
    'subtitle' => __('Be the first to know when we launch. No spam, ever.'),
    'cta' => __('Notify me'),
])

<section {{ $attributes->class('py-20 px-6 bg-zinc-950 rounded-3xl') }}>
    <div class="relative mx-auto max-w-2xl text-center">
        <div class="absolute inset-0 -z-10 mx-auto h-40 w-40 rounded-full bg-purple-500/20 blur-3xl"></div>
        <div class="absolute inset-0 -z-10 mx-auto mt-20 h-40 w-40 rounded-full bg-blue-500/20 blur-3xl"></div>
        <h2 class="text-3xl font-bold text-white lg:text-4xl">{{ $heading }}</h2>
        <p class="mt-4 text-zinc-400">{{ $subtitle }}</p>
        <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row">
            <input type="email" placeholder="{{ __('Enter your email') }}" class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-zinc-500 focus:outline-none sm:max-w-xs" />
            <gsmui:button>{{ $cta }}</gsmui:button>
        </div>
        <div class="absolute -inset-px rounded-3xl border border-white/10 pointer-events-none"></div>
    </div>
</section>
