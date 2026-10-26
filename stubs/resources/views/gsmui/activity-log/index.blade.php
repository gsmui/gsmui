@props([
    'logs' => [],
    'actions' => [],
    'class' => '',
])

<?php
$id = 'activity-log-' . uniqid();
$actions = $actions ?: ['All', 'Create', 'Update', 'Delete', 'Login', 'Export', 'Settings'];
$logs = $logs ?: [];
for ($i = 1; $i <= 20; $i++) {
    $logs[] = [
        'id' => $i, 'user' => ['name' => ['Admin', 'John', 'Sarah', 'Mike'][rand(0,3)], 'avatar' => ''],
        'action' => ['Create', 'Update', 'Delete', 'Login', 'Export', 'Settings'][rand(0,5)],
        'description' => ['Created new page "About Us"', 'Updated user profile', 'Deleted expired sessions', 'Logged in from new device', 'Exported user report', 'Changed site settings'][rand(0,5)],
        'ip' => '192.168.' . rand(1,255) . '.' . rand(1,255),
        'user_agent' => 'Mozilla/5.0...',
        'timestamp' => rand(1, 24) . 'h ago',
    ];
}
?>

<div 
    class="gsmui-activity-log {{ $class }}"
    x-data="gsmuiActivityLog({
        logs: @js($logs),
        actions: @js($actions),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div><h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Activity Log</h2><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Audit trail of all system actions and events.</p></div>
            <button @click="exportLogs" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700">Export CSV</button>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="search" x-model="search" class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Search activity..." />
            </div>
            <select x-model="filterAction" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                <template x-for="a in actions" :key="a"><option :value="a === 'All' ? '' : a.toLowerCase()" x-text="a"></option></template>
            </select>
            <select x-model="filterUser" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                <option value="">All Users</option>
                <option value="Admin">Admin</option><option value="John">John</option><option value="Sarah">Sarah</option>
            </select>
            <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400 ml-auto">
                <span x-text="filteredLogs.length + ' events'"></span>
            </div>
        </div>

        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                        <tr>
                            <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">User</th>
                            <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Action</th>
                            <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Description</th>
                            <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider hidden lg:table-cell">IP Address</th>
                            <th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        <template x-for="log in paginatedLogs" :key="log.id">
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-primary/20 flex items-center justify-center text-xs font-medium text-primary" x-text="log.user.name[0]"></div>
                                        <span class="text-sm font-medium text-zinc-900 dark:text-white" x-text="log.user.name"></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-xs px-2 py-0.5 rounded-full capitalize font-medium"
                                        :class="{
                                            'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700': log.action === 'Create',
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-700': log.action === 'Update',
                                            'bg-red-100 dark:bg-red-900/30 text-red-700': log.action === 'Delete',
                                            'bg-purple-100 dark:bg-purple-900/30 text-purple-700': log.action === 'Login',
                                            'bg-amber-100 dark:bg-amber-900/30 text-amber-700': log.action === 'Export',
                                            'bg-zinc-100 dark:bg-zinc-700 text-zinc-600': log.action === 'Settings',
                                        }"
                                        x-text="log.action">
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400" x-text="log.description"></td>
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 font-mono text-xs hidden lg:table-cell" x-text="log.ip"></td>
                                <td class="px-4 py-3 text-right text-sm text-zinc-500 dark:text-zinc-400 tabular-nums" x-text="log.timestamp"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <template x-if="filteredLogs.length === 0">
                <div class="p-8 text-center text-zinc-500 dark:text-zinc-400"><p>No activity found matching your filters.</p></div>
            </template>
        </div>

        <div class="flex items-center justify-between" x-show="totalPages > 1">
            <span class="text-sm text-zinc-500" x-text="'Page ' + page + ' of ' + totalPages"></span>
            <div class="flex gap-2">
                <button @click="page--" :disabled="page === 1" class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg disabled:opacity-50 hover:bg-zinc-50">← Previous</button>
                <button @click="page++" :disabled="page >= totalPages" class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg disabled:opacity-50 hover:bg-zinc-50">Next →</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiActivityLog', (config) => ({
        logs: config.logs, actions: config.actions,
        search: '', filterAction: '', filterUser: '', page: 1, perPage: 10,

        get filteredLogs() {
            let r = this.logs;
            if (this.search) { const q = this.search.toLowerCase(); r = r.filter(l => l.description.toLowerCase().includes(q) || l.user.name.toLowerCase().includes(q)); }
            if (this.filterAction) r = r.filter(l => l.action.toLowerCase() === this.filterAction);
            if (this.filterUser) r = r.filter(l => l.user.name === this.filterUser);
            return r;
        },
        get totalPages() { return Math.ceil(this.filteredLogs.length / this.perPage); },
        get paginatedLogs() { const s = (this.page-1)*this.perPage; return this.filteredLogs.slice(s, s+this.perPage); },
        exportLogs() {
            const csv = 'User,Action,Description,IP,Time\n' + this.filteredLogs.map(l => `${l.user.name},${l.action},"${l.description}",${l.ip},${l.timestamp}`).join('\n');
            const b = new Blob([csv], {type:'text/csv'}); const u = URL.createObjectURL(b); const a = document.createElement('a'); a.href=u; a.download='activity-log.csv'; a.click(); URL.revokeObjectURL(u);
        },
    }));
});
</script>
