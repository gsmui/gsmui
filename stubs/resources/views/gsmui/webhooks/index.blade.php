@props([
    'endpoints' => [],
    'logs' => [],
    'class' => '',
])

<?php
$id = 'webhooks-' . uniqid();
$endpoints = $endpoints ?: [
    ['id' => 1, 'name' => 'Order Created', 'url' => 'https://api.example.com/webhooks/orders', 'events' => ['order.created'], 'status' => 'active', 'last_sent' => '2h ago', 'success_rate' => 98],
    ['id' => 2, 'name' => 'User Registered', 'url' => 'https://hooks.slack.com/services/T...', 'events' => ['user.registered'], 'status' => 'active', 'last_sent' => '5m ago', 'success_rate' => 100],
    ['id' => 3, 'name' => 'Payment Failed', 'url' => 'https://api.example.com/webhooks/alerts', 'events' => ['payment.failed'], 'status' => 'paused', 'last_sent' => '1d ago', 'success_rate' => 75],
];
?>

<div 
    class="gsmui-webhooks {{ $class }}"
    x-data="gsmuiWebhooks({
        endpoints: @js($endpoints),
        logs: @js($logs),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Webhooks</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage outgoing webhook endpoints.</p>
            </div>
            <button @click="showAddEndpoint = true" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ Add Endpoint</button>
        </div>

        <div class="space-y-3">
            <template x-for="ep in endpoints" :key="ep.id">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="font-medium text-zinc-900 dark:text-white" x-text="ep.name"></h3>
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium capitalize"
                                    :class="ep.status === 'active' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700'"
                                    x-text="ep.status">
                                </span>
                            </div>
                            <code class="block text-xs font-mono text-zinc-500 dark:text-zinc-400 mt-1 truncate" x-text="ep.url"></code>
                        </div>
                        <div class="flex items-center gap-3 ml-4 flex-shrink-0">
                            <div class="text-right text-xs text-zinc-500 dark:text-zinc-400">
                                <div class="font-medium tabular-nums" :class="ep.success_rate >= 90 ? 'text-emerald-600' : 'text-red-500'" x-text="ep.success_rate + '%'"></div>
                                <div>success</div>
                            </div>
                            <button @click="toggleEndpoint(ep)" class="relative w-10 h-5 rounded-full transition-colors"
                                :class="ep.status === 'active' ? 'bg-primary' : 'bg-zinc-300 dark:bg-zinc-600'">
                                <div class="absolute w-4 h-4 bg-white rounded-full shadow top-0.5 transition-transform"
                                    :class="ep.status === 'active' ? 'translate-x-[22px]' : 'translate-x-0.5'"></div>
                            </button>
                            <button @click="deleteEndpoint(ep)" class="p-1 text-zinc-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5 mt-2">
                        <template x-for="evt in ep.events" :key="evt">
                            <code class="text-xs px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded text-zinc-600 dark:text-zinc-400" x-text="evt"></code>
                        </template>
                    </div>
                    <div class="flex items-center justify-between mt-2 text-xs text-zinc-400">
                        <span x-text="'Last sent: ' + ep.last_sent"></span>
                        <button @click="testEndpoint(ep)" class="text-primary hover:underline">Test</button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Recent Attempts -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Recent Deliveries</h3>
            </div>
            <div class="p-4">
                <table class="w-full">
                    <thead><tr class="text-xs text-zinc-500 uppercase tracking-wider"><th class="text-left pb-2">Event</th><th class="text-left pb-2">Endpoint</th><th class="text-center pb-2">Status</th><th class="text-right pb-2">Time</th></tr></thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        <template x-for="i in 5" :key="i">
                            <tr class="text-sm">
                                <td class="py-2 text-zinc-900 dark:text-white font-mono text-xs">user.registered</td>
                                <td class="py-2 text-zinc-500">User Registered</td>
                                <td class="py-2 text-center"><span class="text-xs px-1.5 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 rounded">Success</span></td>
                                <td class="py-2 text-right text-zinc-400 tabular-nums">200ms</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Endpoint Modal -->
        <template x-if="showAddEndpoint">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="showAddEndpoint = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-md w-full p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">New Webhook Endpoint</h3>
                    <div class="space-y-3">
                        <div><label class="block text-sm font-medium mb-1">Name</label><input type="text" x-model="newEp.name" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" /></div>
                        <div><label class="block text-sm font-medium mb-1">Payload URL</label><input type="url" x-model="newEp.url" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono" placeholder="https://..." /></div>
                        <div><label class="block text-sm font-medium mb-1">Events</label><div class="space-y-1"><template x-for="evt in ['user.registered', 'user.updated', 'order.created', 'payment.received', 'payment.failed']" :key="evt"><label class="flex items-center gap-2 text-sm"><input type="checkbox" :value="evt" x-model="newEp.events" class="w-4 h-4 text-primary rounded border-zinc-300" /><span x-text="evt"></span></label></template></div></div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="showAddEndpoint = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                        <button @click="addEndpoint" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Create</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiWebhooks', (config) => ({
        endpoints: config.endpoints,
        logs: config.logs,
        showAddEndpoint: false,
        newEp: { name: '', url: '', events: [] },

        toggleEndpoint(ep) {
            ep.status = ep.status === 'active' ? 'paused' : 'active';
        },

        deleteEndpoint(ep) {
            this.endpoints = this.endpoints.filter(e => e.id !== ep.id);
        },

        addEndpoint() {
            if (!this.newEp.name || !this.newEp.url) return;
            this.endpoints.push({ id: Date.now(), ...this.newEp, status: 'active', last_sent: 'Never', success_rate: 100 });
            this.newEp = { name: '', url: '', events: [] };
            this.showAddEndpoint = false;
        },

        testEndpoint(ep) {
            this.$dispatch('webhooks:test', { endpoint: ep });
        },
    }));
});
</script>
