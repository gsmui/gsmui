@props([
    'heading' => __('Ship faster, together'),
    'subtitle' => __('The collaborative platform that helps teams build, test, and deploy with confidence.'),
    'primaryCta' => __('Start free trial'),
    'secondaryCta' => __('Watch demo'),
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="space-y-6">
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-5xl">{{ $heading }}</h1>
                <p class="text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <gsmui:button size="lg">{{ $primaryCta }}</gsmui:button>
                    <gsmui:button size="lg" variant="outline">{{ $secondaryCta }}</gsmui:button>
                </div>
            </div>
            <div class="aspect-video rounded-2xl bg-zinc-100 dark:bg-white/5 border border-zinc-200 dark:border-white/10"></div>
        </div>
    </div>
</section>
