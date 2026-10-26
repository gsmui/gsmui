@props([
    'contacts' => [],
    'pipelines' => [],
    'deals' => [],
    'class' => '',
])

<?php
$id = 'crm-' . uniqid();
$contacts = $contacts ?: [
    ['id' => 1, 'name' => 'John Smith', 'email' => 'john@acme.com', 'company' => 'Acme Inc', 'phone' => '+1-555-0100', 'status' => 'active', 'deals' => 3, 'revenue' => 24000],
    ['id' => 2, 'name' => 'Sarah Johnson', 'email' => 'sarah@techcorp.com', 'company' => 'TechCorp', 'phone' => '+1-555-0101', 'status' => 'active', 'deals' => 1, 'revenue' => 8500],
    ['id' => 3, 'name' => 'Mike Brown', 'email' => 'mike@startup.io', 'company' => 'Startup IO', 'phone' => '+1-555-0102', 'status' => 'lead', 'deals' => 0, 'revenue' => 0],
];
$pipelines = $pipelines ?: [
    ['stage' => 'Lead', 'deals' => 12, 'value' => 45000],
    ['stage' => 'Qualified', 'deals' => 8, 'value' => 62000],
    ['stage' => 'Proposal', 'deals' => 5, 'value' => 48000],
    ['stage' => 'Negotiation', 'deals' => 3, 'value' => 35000],
    ['stage' => 'Closed Won', 'deals' => 15, 'value' => 120000],
];
?>

<div 
    class="gsmui-crm {{ $class }}"
    x-data="gsmuiCrm({
        contacts: @js($contacts),
        pipelines: @js($pipelines),
        deals: @js($deals),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">CRM</h2>
            <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ Add Contact</button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="contacts.length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Contacts</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="pipelines.reduce((s, p) => s + p.deals, 0)"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Active Deals</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-emerald-600" x-text="'$' + pipelines.reduce((s, p) => s + p.value, 0).toLocaleString()"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Pipeline Value</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="contacts.filter(c => c.status === 'active').length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Active</div>
            </div>
        </div>

        <!-- Pipeline -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Pipeline</h3>
            </div>
            <div class="p-4 overflow-x-auto">
                <div class="flex gap-4 min-w-max">
                    <template x-for="(stage, si) in pipelines" :key="si">
                        <div class="w-56">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full" :class="{
                                        'bg-zinc-400': si === 0,
                                        'bg-blue-500': si === 1,
                                        'bg-amber-500': si === 2,
                                        'bg-purple-500': si === 3,
                                        'bg-emerald-500': si === 4,
                                    }"></div>
                                    <span class="font-medium text-sm text-zinc-900 dark:text-white" x-text="stage.stage"></span>
                                </div>
                                <span class="text-xs text-zinc-500 dark:text-zinc-400" x-text="stage.deals"></span>
                            </div>
                            <div class="space-y-2">
                                <template x-for="i in Math.min(3, stage.deals)" :key="i">
                                    <div class="p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900 cursor-pointer hover:shadow-sm transition-shadow">
                                        <div class="font-medium text-sm text-zinc-900 dark:text-white">Deal #@{{i}}</div>
                                        <div class="text-xs text-zinc-500 mt-1">$@{{(stage.value / stage.deals * i).toLocaleString()}}</div>
                                    </div>
                                </template>
                                <template x-if="stage.deals > 3">
                                    <div class="text-center text-xs text-zinc-400 py-1">+@{{stage.deals - 3}} more</div>
                                </template>
                            </div>
                            <div class="mt-2 text-sm font-medium text-zinc-900 dark:text-white" x-text="'$' + stage.value.toLocaleString()"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Contacts Table -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Contacts</h3>
                <div class="relative max-w-xs">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="search" x-model="search" class="w-full pl-9 pr-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Search contacts..." />
                </div>
            </div>
            <table class="w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Name</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Company</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Email</th><th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th><th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Revenue</th><th class="text-right px-4 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <template x-for="contact in filteredContacts" :key="contact.id">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-white" x-text="contact.name"></td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400" x-text="contact.company"></td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400" x-text="contact.email"></td>
                            <td class="px-4 py-3 text-center"><span class="text-xs px-2 py-0.5 rounded-full capitalize" :class="contact.status === 'active' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700'" x-text="contact.status"></span></td>
                            <td class="px-4 py-3 text-right text-sm font-medium tabular-nums" x-text="'$' + contact.revenue.toLocaleString()"></td>
                            <td class="px-4 py-3 text-right"><button class="text-sm text-primary hover:underline">View</button></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiCrm', (config) => ({
        contacts: config.contacts,
        pipelines: config.pipelines,
        deals: config.deals,
        search: '',

        get filteredContacts() {
            if (!this.search) return this.contacts;
            const q = this.search.toLowerCase();
            return this.contacts.filter(c => c.name.toLowerCase().includes(q) || c.company.toLowerCase().includes(q) || c.email.toLowerCase().includes(q));
        },
    }));
});
</script>
