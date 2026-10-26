@props([
    'backups' => [],
    'disks' => [],
    'class' => '',
])

<?php
$id = 'backup-manager-' . uniqid();
$disks = $disks ?: ['local', 's3', 'gcs', 'dropbox'];
$backups = $backups ?: [
    ['id' => 1, 'name' => 'full-backup-2024-01-15.zip', 'size' => '256 MB', 'disk' => 's3', 'created_at' => '2024-01-15 03:00:00', 'status' => 'completed', 'type' => 'Full'],
    ['id' => 2, 'name' => 'db-backup-2024-01-15.sql.gz', 'size' => '42 MB', 'disk' => 'local', 'created_at' => '2024-01-15 02:00:00', 'status' => 'completed', 'type' => 'Database'],
    ['id' => 3, 'name' => 'files-backup-2024-01-14.zip', 'size' => '1.2 GB', 'disk' => 's3', 'created_at' => '2024-01-14 03:00:00', 'status' => 'completed', 'type' => 'Files'],
    ['id' => 4, 'name' => 'partial-backup-2024-01-13.zip', 'size' => '89 MB', 'disk' => 'local', 'created_at' => '2024-01-13 03:00:00', 'status' => 'failed', 'type' => 'Partial'],
];
?>

<div 
    class="gsmui-backup-manager {{ $class }}"
    x-data="gsmuiBackupManager({
        backups: @js($backups),
        disks: @js($disks),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div><h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Backup Manager</h2><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Create and manage system backups.</p></div>
            <div class="flex items-center gap-2">
                <template x-if="creating">
                    <span class="text-sm text-amber-500 animate-pulse">Creating backup...</span>
                </template>
                <button @click="createBackup('full')" :disabled="creating" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90 disabled:opacity-50">+ Full Backup</button>
                <button @click="createBackup('database')" :disabled="creating" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 disabled:opacity-50">DB Only</button>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800"><div class="text-2xl font-bold" x-text="backups.length"></div><div class="text-sm text-zinc-500">Total Backups</div></div>
            <div class="p-4 rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800"><div class="text-2xl font-bold text-emerald-600" x-text="backups.filter(b => b.status === 'completed').length"></div><div class="text-sm text-zinc-500">Successful</div></div>
            <div class="p-4 rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800"><div class="text-2xl font-bold text-red-500" x-text="backups.filter(b => b.status === 'failed').length"></div><div class="text-sm text-zinc-500">Failed</div></div>
            <div class="p-4 rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800"><div class="text-2xl font-bold" x-text="formatSize(backups.reduce((s,b) => s + parseSize(b.size), 0))"></div><div class="text-sm text-zinc-500">Total Size</div></div>
        </div>

        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <table class="w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Name</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Type</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Disk</th><th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Size</th><th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th><th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Date</th><th class="text-right px-4 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <template x-for="backup in backups" :key="backup.id">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-white truncate max-w-[200px]" x-text="backup.name"></td>
                            <td class="px-4 py-3"><span class="text-xs px-2 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-700 text-zinc-600" x-text="backup.type"></span></td>
                            <td class="px-4 py-3 text-sm text-zinc-500 font-mono text-xs uppercase" x-text="backup.disk"></td>
                            <td class="px-4 py-3 text-right text-sm text-zinc-600 tabular-nums" x-text="backup.size"></td>
                            <td class="px-4 py-3 text-center"><span class="text-xs px-2 py-0.5 rounded-full font-medium" :class="backup.status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'" x-text="backup.status"></span></td>
                            <td class="px-4 py-3 text-right text-sm text-zinc-500 tabular-nums" x-text="backup.created_at"></td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button @click="downloadBackup(backup)" class="p-1.5 rounded hover:bg-zinc-100 text-zinc-500 hover:text-primary" title="Download"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg></button>
                                    <button @click="restoreBackup(backup)" class="p-1.5 rounded hover:bg-zinc-100 text-zinc-500 hover:text-emerald-500" title="Restore"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></button>
                                    <button @click="deleteBackup(backup)" class="p-1.5 rounded hover:bg-red-50 text-zinc-500 hover:text-red-500" title="Delete"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <template x-if="backups.length === 0">
                <div class="p-8 text-center text-zinc-500"><p>No backups yet. Create your first backup.</p></div>
            </template>
        </div>

        <!-- Schedule Config -->
        <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">Schedule</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div><label class="block text-sm text-zinc-500 mb-1">Frequency</label><select class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><option>Daily</option><option>Weekly</option><option>Monthly</option></select></div>
                <div><label class="block text-sm text-zinc-500 mb-1">Retention</label><select class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><option>7 days</option><option>30 days</option><option selected>90 days</option></select></div>
                <div><label class="block text-sm text-zinc-500 mb-1">Disk</label><select class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><template x-for="disk in disks" :key="disk"><option :value="disk" x-text="disk.toUpperCase()"></option></template></select></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiBackupManager', (config) => ({
        backups: config.backups, disks: config.disks, creating: false,

        createBackup(type) {
            this.creating = true;
            setTimeout(() => {
                this.backups.unshift({
                    id: Date.now(),
                    name: `${type}-backup-${new Date().toISOString().slice(0,10)}.zip`,
                    size: (Math.random() * 500 + 10).toFixed(0) + ' MB',
                    disk: 'local',
                    created_at: new Date().toISOString().replace('T', ' ').slice(0, 19),
                    status: Math.random() > 0.1 ? 'completed' : 'failed',
                    type: type.charAt(0).toUpperCase() + type.slice(1),
                });
                this.creating = false;
            }, 2000);
        },
        downloadBackup(backup) { this.$dispatch('backup:download', { backup }); },
        restoreBackup(backup) { if (confirm('Restore this backup? This may overwrite current data.')) this.$dispatch('backup:restore', { backup }); },
        deleteBackup(backup) { if (confirm('Delete this backup?')) this.backups = this.backups.filter(b => b.id !== backup.id); },
        formatSize(bytes) { if (bytes >= 1073741824) return (bytes/1073741824).toFixed(1) + ' GB'; if (bytes >= 1048576) return (bytes/1048576).toFixed(1) + ' MB'; return (bytes/1024).toFixed(1) + ' KB'; },
        parseSize(str) { const m = str.match(/([\d.]+)\s*(MB|GB|KB)/); if (!m) return 0; const v = parseFloat(m[1]); return m[2] === 'GB' ? v * 1073741824 : m[2] === 'MB' ? v * 1048576 : v * 1024; },
    }));
});
</script>
