@props([
    'plans' => [],
    'currentPlan' => null,
    'invoices' => [],
    'paymentMethods' => [],
    'class' => '',
])

<?php
$id = 'billing-' . uniqid();
$plans = $plans ?: [
    ['id' => 'free', 'name' => 'Free', 'price' => 0, 'features' => ['1 project', '5 team members', '100 MB storage', 'Community support'], 'popular' => false],
    ['id' => 'pro', 'name' => 'Pro', 'price' => 29, 'features' => ['Unlimited projects', '50 team members', '10 GB storage', 'Priority support', 'API access', 'Custom domains'], 'popular' => true],
    ['id' => 'enterprise', 'name' => 'Enterprise', 'price' => 99, 'features' => ['Everything in Pro', 'Unlimited team members', '100 GB storage', 'Dedicated support', 'SAML/SSO', 'Audit logs', 'Custom integrations'], 'popular' => false],
];
$invoices = $invoices ?: [
    ['id' => 1, 'date' => '2024-01-01', 'amount' => 29, 'status' => 'paid', 'description' => 'Pro Plan - January 2024'],
    ['id' => 2, 'date' => '2023-12-01', 'amount' => 29, 'status' => 'paid', 'description' => 'Pro Plan - December 2023'],
    ['id' => 3, 'date' => '2023-11-01', 'amount' => 0, 'status' => 'free', 'description' => 'Free Plan - November 2023'],
];
?>

<div 
    class="gsmui-billing {{ $class }}"
    x-data="gsmuiBilling({
        plans: @js($plans),
        currentPlan: '{{ $currentPlan ?? 'free' }}',
        invoices: @js($invoices),
        paymentMethods: @js($paymentMethods),
    })"
    id="{{ $id }}"
>
    <div class="space-y-8">
        <!-- Header -->
        <div>
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Billing & Subscriptions</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage your plan, payment methods, and invoices.</p>
        </div>

        <!-- Current Plan -->
        <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white">Current Plan</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                        You are on the <strong class="text-primary capitalize" x-text="currentPlan"></strong> plan.
                    </p>
                </div>
                <span class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="'$' + (plans.find(p => p.id === currentPlan)?.price || 0) + '/mo'"></span>
            </div>
        </div>

        <!-- Plans -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <template x-for="plan in plans" :key="plan.id">
                <div class="relative p-5 rounded-xl border transition-shadow"
                    :class="plan.popular ? 'border-primary shadow-lg ring-2 ring-primary/20' : 'border-zinc-200 dark:border-zinc-700 hover:shadow-md'">
                    <template x-if="plan.popular">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-0.5 bg-primary text-white text-xs font-medium rounded-full">Most Popular</div>
                    </template>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white" x-text="plan.name"></h3>
                        <div class="mt-2">
                            <span class="text-3xl font-bold text-zinc-900 dark:text-white" x-text="'$' + plan.price"></span>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">/month</span>
                        </div>
                    </div>
                    <ul class="space-y-2 mb-6">
                        <template x-for="feature in plan.features" :key="feature">
                            <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span x-text="feature"></span>
                            </li>
                        </template>
                    </ul>
                    <button @click="switchPlan(plan)" 
                        class="w-full py-2 rounded-lg text-sm font-medium transition-colors"
                        :class="currentPlan === plan.id ? 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400 cursor-default' : 'bg-primary text-white hover:bg-primary/90'"
                        x-text="currentPlan === plan.id ? 'Current Plan' : 'Switch to ' + plan.name">
                    </button>
                </div>
            </template>
        </div>

        <!-- Payment Method -->
        <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Payment Method</h3>
            <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg">
                <svg class="w-10 h-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <div class="flex-1">
                    <div class="text-sm font-medium text-zinc-900 dark:text-white">Visa ending in 4242</div>
                    <div class="text-xs text-zinc-500 dark:text-zinc-400">Expires 12/2026</div>
                </div>
                <button class="text-sm text-primary hover:underline">Update</button>
            </div>
        </div>

        <!-- Invoices -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Invoices</h3>
            </div>
            <table class="w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Date</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Description</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Amount</th>
                        <th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <template x-for="invoice in invoices" :key="invoice.id">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400" x-text="invoice.date"></td>
                            <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white" x-text="invoice.description"></td>
                            <td class="px-4 py-3 text-right text-sm font-medium text-zinc-900 dark:text-white" x-text="invoice.amount === 0 ? 'Free' : '$' + invoice.amount"></td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-xs px-2 py-0.5 rounded-full capitalize"
                                    :class="{
                                        'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400': invoice.status === 'paid',
                                        'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400': invoice.status === 'free',
                                    }"
                                    x-text="invoice.status">
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button class="text-sm text-primary hover:underline">Download</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiBilling', (config) => ({
        plans: config.plans,
        currentPlan: config.currentPlan,
        invoices: config.invoices,
        paymentMethods: config.paymentMethods,

        switchPlan(plan) {
            if (this.currentPlan !== plan.id) {
                this.currentPlan = plan.id;
                this.$dispatch('billing:plan-changed', { plan: plan.id });
            }
        },
    }));
});
</script>
