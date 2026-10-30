<div>
    <div class="max-w-4xl">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Subscription</h1>

        {{-- Current Plan --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 mb-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Current Plan</h2>
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center">
                    <span class="text-2xl">📦</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white capitalize">{{ $currentPlan }}</p>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        @if($currentPlan === 'free')
                            Free forever
                        @else
                            ${{ $currentPlan === 'pro' ? '19' : '99' }}/month
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Available Plans --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 bg-white dark:bg-zinc-950">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Pro</h3>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">$19<span class="text-sm font-normal text-zinc-500">/month</span></p>
                <ul class="mt-4 space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                    <li>✓ Premium components</li>
                    <li>✓ Premium templates</li>
                    <li>✓ Advanced themes</li>
                    <li>✓ AI tools</li>
                    <li>✓ Priority support</li>
                </ul>
                @if($currentPlan !== 'pro')
                    <button wire:click="subscribe('pro')" class="mt-6 w-full px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                        Upgrade to Pro
                    </button>
                @endif
            </div>

            <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 bg-white dark:bg-zinc-950">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Enterprise</h3>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">$99<span class="text-sm font-normal text-zinc-500">/month</span></p>
                <ul class="mt-4 space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                    <li>✓ Everything in Pro</li>
                    <li>✓ Unlimited users</li>
                    <li>✓ White-label licensing</li>
                    <li>✓ Dedicated support</li>
                    <li>✓ SLA</li>
                </ul>
                @if($currentPlan !== 'enterprise')
                    <button wire:click="subscribe('enterprise')" class="mt-6 w-full px-4 py-2 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-white rounded-lg text-sm font-medium hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                        Upgrade to Enterprise
                    </button>
                @endif
            </div>
        </div>

        @if($currentPlan !== 'free')
            <div class="mt-6">
                <button wire:click="cancelSubscription" wire:confirm="Are you sure you want to cancel?" class="text-sm text-red-600 hover:text-red-700">
                    Cancel Subscription
                </button>
            </div>
        @endif
    </div>
</div>
