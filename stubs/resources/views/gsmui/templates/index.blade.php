@props([
    'categories' => [
        ['id' => 'developer-portfolio', 'name' => 'Developer Portfolio', 'count' => 5, 'type' => 'page', 'desc' => 'Minimal dark, split screen, terminal, clean cards, bento grid.'],
        ['id' => 'uiux-portfolio', 'name' => 'UI/UX Portfolio', 'count' => 5, 'type' => 'page', 'desc' => 'Visual showcase, case study, masonry, process steps, bold typography.'],
        ['id' => 'agency', 'name' => 'Agency', 'count' => 5, 'type' => 'page', 'desc' => 'Corporate, creative studio, dark showcase, minimal services, team split.'],
        ['id' => 'startup', 'name' => 'Startup', 'count' => 5, 'type' => 'page', 'desc' => 'SaaS features, waitlist, product demo, investor pitch, community.'],
        ['id' => 'saas-landing', 'name' => 'SaaS Landing', 'count' => 5, 'type' => 'page', 'desc' => 'Classic, dark dashboard, minimal CTA, comparison, social proof.'],
        ['id' => 'app-landing', 'name' => 'App Landing', 'count' => 5, 'type' => 'page', 'desc' => 'Phone mockup, app store badges, feature walkthrough, dark glowing, download.'],
        ['id' => 'ai-landing', 'name' => 'AI Landing', 'count' => 5, 'type' => 'page', 'desc' => 'Demo area, futuristic neural net, chat interface, before/after, enterprise.'],
        ['id' => 'ecommerce', 'name' => 'Ecommerce', 'count' => 5, 'type' => 'page', 'desc' => 'Product grid, featured hero, category browse, sale promo, product detail.'],
        ['id' => 'restaurant', 'name' => 'Restaurant', 'count' => 5, 'type' => 'page', 'desc' => 'Fine dining, casual bistro, dark food gallery, cafe, food truck.'],
        ['id' => 'real-estate', 'name' => 'Real Estate', 'count' => 5, 'type' => 'page', 'desc' => 'Listing grid, luxury showcase, agent listings, search, new development.'],
        ['id' => 'education', 'name' => 'Education', 'count' => 5, 'type' => 'page', 'desc' => 'Online course, university, bootcamp, tutorial, LMS dashboard.'],
        ['id' => 'finance', 'name' => 'Finance', 'count' => 5, 'type' => 'page', 'desc' => 'Banking, investment, crypto exchange, insurance, accounting.'],
        ['id' => 'blog', 'name' => 'Blog', 'count' => 5, 'type' => 'page', 'desc' => 'Classic listing, magazine, sidebar, dark tech, photo editorial.'],
        ['id' => 'event', 'name' => 'Event', 'count' => 5, 'type' => 'page', 'desc' => 'Conference, music festival, webinar, wedding, charity gala.'],
        ['id' => 'coming-soon', 'name' => 'Coming Soon', 'count' => 5, 'type' => 'page', 'desc' => 'Countdown, dark progress, minimal social, maintenance, launch teaser.'],
        ['id' => 'health-fitness', 'name' => 'Health & Fitness', 'count' => 5, 'type' => 'page', 'desc' => 'Gym, wellness spa, personal trainer, health app, yoga.'],
        ['id' => 'hero-sections', 'name' => 'Hero Sections', 'count' => 10, 'type' => 'section', 'desc' => 'Centered gradient, split image, video bg, search, product showcase, and more.'],
        ['id' => 'features', 'name' => 'Features', 'count' => 10, 'type' => 'section', 'desc' => 'Icon grid, alternating image/text, bento grid, comparison table, tabbed, and more.'],
        ['id' => 'pricing', 'name' => 'Pricing', 'count' => 5, 'type' => 'section', 'desc' => '3-tier cards, comparison table, monthly/annual toggle, spotlight, enterprise.'],
        ['id' => 'testimonials', 'name' => 'Testimonials', 'count' => 5, 'type' => 'section', 'desc' => 'Card grid, large quote, masonry, social style, minimal single.'],
        ['id' => 'team', 'name' => 'Team', 'count' => 5, 'type' => 'section', 'desc' => 'Grid hover bio, horizontal scroll, org chart, social links, featured member.'],
        ['id' => 'cta', 'name' => 'Call to Action', 'count' => 5, 'type' => 'section', 'desc' => 'Gradient centered, split image, banner, dark glowing, minimal inline.'],
        ['id' => 'faq', 'name' => 'FAQ', 'count' => 5, 'type' => 'section', 'desc' => 'Accordion, two-column, categorized tabs, search, minimal dividers.'],
        ['id' => 'contact', 'name' => 'Contact', 'count' => 5, 'type' => 'section', 'desc' => 'Form + map, centered form, card + sidebar, dark glowing, multi-step.'],
        ['id' => 'footer', 'name' => 'Footer', 'count' => 5, 'type' => 'section', 'desc' => 'Multi-column links, minimal newsletter, dark social, sitemap, copyright bar.'],
    ],
])

@php
$total = collect($categories)->sum('count');
$pageTemplates = collect($categories)->where('type', 'page')->sum('count');
$sectionTemplates = collect($categories)->where('type', 'section')->sum('count');
$pageCategories = collect($categories)->where('type', 'page');
$sectionCategories = collect($categories)->where('type', 'section');
@endphp

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div>
                <h1 class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro Templates</h1>
                <p class="text-sm text-zinc-500">{{ $total }} production-ready templates across {{ count($categories) }} categories</p>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-xs font-medium text-blue-700 dark:text-blue-300">{{ $total }} Templates</span>
                <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300">Dark Mode</span>
                <span class="rounded-full bg-violet-100 dark:bg-violet-900/30 px-3 py-1 text-xs font-medium text-violet-700 dark:text-violet-300">Livewire Ready</span>
            </div>
        </div>
        <div class="border-t border-zinc-200 dark:border-white/10 overflow-x-auto">
            <div class="mx-auto flex max-w-7xl gap-1 px-6 py-2 text-xs font-medium text-zinc-500">
                @foreach ($categories as $cat)
                    <a href="#cat-{{ $cat['id'] }}" class="shrink-0 rounded-md px-2 py-1 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white transition-all capitalize">{{ str_replace('-', ' ', $cat['id']) }}</a>
                @endforeach
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-12">
        {{-- Page Templates Section --}}
        <section class="mb-16">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Full Page Templates</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $pageCategories->count() }} categories &middot; {{ $pageTemplates }} complete landing pages</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($pageCategories as $cat)
                    <a href="#cat-{{ $cat['id'] }}" id="cat-{{ $cat['id'] }}" class="group rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md hover:border-zinc-300 dark:hover:border-zinc-600 transition-all scroll-mt-20">
                        <div class="flex items-center justify-between mb-2">
                            <span class="rounded-full bg-blue-100 dark:bg-blue-900/30 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:text-blue-300">Page</span>
                            <span class="text-xs text-zinc-400">{{ $cat['count'] }} variants</span>
                        </div>
                        <h3 class="text-base font-semibold text-zinc-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $cat['name'] }}</h3>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">{{ $cat['desc'] }}</p>
                        <div class="mt-3 flex items-center gap-1 text-xs text-zinc-400">
                            <span class="font-mono">gsmui::templates.{{ $cat['id'] }}-1</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Section Templates Section --}}
        <section>
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Section Templates</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $sectionCategories->count() }} categories &middot; {{ $sectionTemplates }} reusable sections</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($sectionCategories as $cat)
                    <a href="#cat-{{ $cat['id'] }}" id="cat-{{ $cat['id'] }}" class="group rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md hover:border-zinc-300 dark:hover:border-zinc-600 transition-all scroll-mt-20">
                        <div class="flex items-center justify-between mb-2">
                            <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:text-emerald-300">Section</span>
                            <span class="text-xs text-zinc-400">{{ $cat['count'] }} variants</span>
                        </div>
                        <h3 class="text-base font-semibold text-zinc-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $cat['name'] }}</h3>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">{{ $cat['desc'] }}</p>
                        <div class="mt-3 flex items-center gap-1 text-xs text-zinc-400">
                            <span class="font-mono">gsmui::templates.{{ $cat['id'] }}-1</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- All Templates --}}
        <section class="mt-24 space-y-24">
            @foreach ($categories as $cat)
                <div id="cat-detail-{{ $cat['id'] }}" class="scroll-mt-20">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <span class="inline-flex items-center gap-2 rounded-full {{ $cat['type'] === 'page' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' }} px-3 py-1 text-xs font-medium">
                                {{ $cat['type'] === 'page' ? 'Full Page' : 'Section' }}
                            </span>
                            <h2 class="mt-2 text-xl font-bold text-zinc-900 dark:text-white">{{ $cat['name'] }}</h2>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $cat['desc'] }}</p>
                        </div>
                    </div>

                    <div class="space-y-12">
                        @for ($i = 1; $i <= $cat['count']; $i++)
                            @php $templateId = $cat['id'] . '-' . $i; @endphp
                            <div>
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Variant {{ $i }}</h3>
                                    <div class="flex items-center gap-2 text-xs text-zinc-400">
                                        <span class="rounded-md border border-zinc-200 dark:border-white/10 px-2 py-1 font-mono">&lt;x-gsmui::templates.{{ $templateId }} /&gt;</span>
                                        <button onclick="navigator.clipboard.writeText('<x-gsmui::templates.{{ $templateId }} />')" class="rounded-md border border-zinc-200 dark:border-white/10 px-2 py-1 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all" title="Copy">Copy</button>
                                    </div>
                                </div>
                                <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-white/10 shadow-sm">
                                    <x-dynamic-component :component="'gsmui::templates.' . $templateId" />
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endforeach
        </section>

        <footer class="mt-24 border-t border-zinc-200 dark:border-white/10 pt-12 pb-8 text-center">
            <p class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro — {{ $total }} Templates</p>
            <p class="mt-2 text-sm text-zinc-500">{{ count($categories) }} categories · Fully responsive · Dark mode ready · Livewire · Tailwind CSS</p>
            <p class="mt-1 text-xs text-zinc-400">Copy any template with <code class="rounded bg-zinc-200 dark:bg-zinc-700 px-1.5 py-0.5 text-xs font-mono">&lt;x-gsmui::templates.{category}-{n} /&gt;</code></p>
        </footer>
    </main>
</div>
