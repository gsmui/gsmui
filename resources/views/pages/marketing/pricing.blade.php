<x-layouts.marketing>
    <div class="py-24">
        <div class="mx-auto max-w-7xl px-4">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-zinc-900 dark:text-white">Simple, transparent pricing</h1>
                <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">Choose the plan that works for you</p>
            </div>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3 max-w-5xl mx-auto">
                {{-- Free --}}
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 p-8 bg-white dark:bg-zinc-950">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Free</h2>
                    <div class="mt-4">
                        <span class="text-4xl font-bold text-zinc-900 dark:text-white">$0</span>
                        <span class="text-zinc-500">/month</span>
                    </div>
                    <ul class="mt-8 space-y-3">
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Core components</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Documentation</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Community themes</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Basic playground</li>
                    </ul>
                    <a href="/register" class="mt-8 block w-full text-center rounded-lg border border-zinc-300 dark:border-zinc-700 px-4 py-3 text-sm font-semibold text-zinc-900 dark:text-white hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                        Get Started
                    </a>
                </div>
                {{-- Pro --}}
                <div class="rounded-xl border-2 border-purple-500 p-8 bg-white dark:bg-zinc-950 relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-purple-600 text-white text-xs font-semibold px-3 py-1 rounded-full">Popular</div>
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Pro</h2>
                    <div class="mt-4">
                        <span class="text-4xl font-bold text-zinc-900 dark:text-white">$19</span>
                        <span class="text-zinc-500">/month</span>
                    </div>
                    <ul class="mt-8 space-y-3">
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Everything in Free</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Premium components</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Premium templates</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Advanced themes</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ AI tools</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Priority support</li>
                    </ul>
                    <a href="/register" class="mt-8 block w-full text-center rounded-lg bg-purple-600 px-4 py-3 text-sm font-semibold text-white hover:bg-purple-500 transition-colors">
                        Get Pro
                    </a>
                </div>
                {{-- Enterprise --}}
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 p-8 bg-white dark:bg-zinc-950">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Enterprise</h2>
                    <div class="mt-4">
                        <span class="text-4xl font-bold text-zinc-900 dark:text-white">$99</span>
                        <span class="text-zinc-500">/month</span>
                    </div>
                    <ul class="mt-8 space-y-3">
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Everything in Pro</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Unlimited users</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ White-label licensing</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Dedicated support</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ SLA</li>
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">✓ Custom integrations</li>
                    </ul>
                    <a href="/contact" class="mt-8 block w-full text-center rounded-lg border border-zinc-300 dark:border-zinc-700 px-4 py-3 text-sm font-semibold text-zinc-900 dark:text-white hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.marketing>
