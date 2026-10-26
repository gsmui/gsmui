@props([
    'announcements' => [],
    'class' => '',
])

<?php
$id = 'announcements-' . uniqid();
$announcements = $announcements ?: [
    ['id' => 1, 'title' => 'Scheduled Maintenance', 'message' => 'The system will be down for maintenance on Jan 20 from 2-4 AM UTC.', 'type' => 'warning', 'active' => true, 'starts_at' => '2024-01-20 02:00', 'expires_at' => '2024-01-20 04:00'],
    ['id' => 2, 'title' => 'New Feature: Dark Mode', 'message' => 'Dark mode is now available in Settings.', 'type' => 'info', 'active' => true, 'starts_at' => '2024-01-15', 'expires_at' => '2024-02-15'],
    ['id' => 3, 'title' => 'API v2 Deprecation', 'message' => 'API v1 will be deprecated on March 1. Please migrate to v2.', 'type' => 'error', 'active' => false, 'starts_at' => '2024-01-01', 'expires_at' => '2024-03-01'],
];
?>

<div 
    class="gsmui-announcements {{ $class }}"
    x-data="gsmuiAnnouncements({
        announcements: @js($announcements),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div><h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Announcements</h2><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Create and manage system-wide announcements.</p></div>
            <button @click="openEditor(null)" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ New Announcement</button>
        </div>

        <div class="space-y-3">
            <template x-for="ann in announcements" :key="ann.id">
                <div class="p-4 rounded-xl border transition-colors"
                    :class="{
                        'border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20': ann.type === 'info',
                        'border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20': ann.type === 'warning',
                        'border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20': ann.type === 'error',
                        'opacity-60': !ann.active
                    }">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                                :class="{'bg-blue-100 dark:bg-blue-900/30 text-blue-600': ann.type === 'info', 'bg-amber-100 dark:bg-amber-900/30 text-amber-600': ann.type === 'warning', 'bg-red-100 dark:bg-red-900/30 text-red-600': ann.type === 'error'}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-zinc-900 dark:text-white" x-text="ann.title"></h3>
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium capitalize"
                                        :class="{'bg-blue-100 text-blue-700': ann.type === 'info', 'bg-amber-100 text-amber-700': ann.type === 'warning', 'bg-red-100 text-red-700': ann.type === 'error'}"
                                        x-text="ann.type">
                                    </span>
                                    <template x-if="!ann.active">
                                        <span class="text-xs px-2 py-0.5 rounded-full bg-zinc-100 text-zinc-600">Inactive</span>
                                    </template>
                                </div>
                                <p class="text-sm mt-1" :class="{'text-zinc-700 dark:text-zinc-300': ann.active, 'text-zinc-500': !ann.active}" x-text="ann.message"></p>
                                <div class="flex items-center gap-3 mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span><span class="text-zinc-400">Starts:</span> <span x-text="ann.starts_at"></span></span>
                                    <span><span class="text-zinc-400">Expires:</span> <span x-text="ann.expires_at"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 ml-4 flex-shrink-0">
                            <button @click="toggleActive(ann)" class="relative w-9 h-4.5 rounded-full transition-colors" :class="ann.active ? 'bg-primary' : 'bg-zinc-300 dark:bg-zinc-600'">
                                <div class="absolute w-3.5 h-3.5 bg-white rounded-full shadow top-0.5 transition-transform" :class="ann.active ? 'translate-x-[18px]' : 'translate-x-0.5'"></div>
                            </button>
                            <button @click="openEditor(ann)" class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-400 hover:text-primary"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <button @click="deleteAnn(ann)" class="p-1.5 rounded hover:bg-red-50 text-zinc-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Editor Modal -->
        <template x-if="editorOpen">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="editorOpen = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-lg w-full p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4" x-text="editingAnn ? 'Edit Announcement' : 'New Announcement'"></h3>
                    <div class="space-y-3">
                        <div><label class="block text-sm font-medium mb-1">Title</label><input type="text" x-model="form.title" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" /></div>
                        <div><label class="block text-sm font-medium mb-1">Message</label><textarea x-model="form.message" rows="3" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"></textarea></div>
                        <div class="grid grid-cols-2 gap-3">
                            <div><label class="block text-sm font-medium mb-1">Type</label><select x-model="form.type" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><option value="info">Info</option><option value="warning">Warning</option><option value="error">Error</option></select></div>
                            <div><label class="flex items-center gap-2 mt-6 text-sm"><input type="checkbox" x-model="form.active" class="w-4 h-4 text-primary rounded border-zinc-300" /> Active</label></div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div><label class="block text-sm font-medium mb-1">Starts At</label><input type="datetime-local" x-model="form.starts_at" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" /></div>
                            <div><label class="block text-sm font-medium mb-1">Expires At</label><input type="datetime-local" x-model="form.expires_at" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" /></div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="editorOpen = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                        <button @click="saveAnn" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Save</button>
                    </div>
                </div>
            </div>
        </template>

        <!-- Preview Banner -->
        <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">Preview</h3>
            <div class="space-y-2">
                <template x-for="ann in announcements.filter(a => a.active).slice(0, 2)" :key="ann.id">
                    <div class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm"
                        :class="{'bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800': ann.type === 'info',
                                'bg-amber-50 dark:bg-amber-900/20 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800': ann.type === 'warning',
                                'bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-800': ann.type === 'error'}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        <span x-text="ann.message"></span>
                    </div>
                </template>
                <template x-if="announcements.filter(a => a.active).length === 0">
                    <p class="text-sm text-zinc-500 text-center py-4">No active announcements.</p>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiAnnouncements', (config) => ({
        announcements: config.announcements,
        editorOpen: false, editingAnn: null,
        form: { title: '', message: '', type: 'info', active: true, starts_at: '', expires_at: '' },

        openEditor(ann) {
            this.editingAnn = ann;
            this.form = ann ? { ...ann } : { title: '', message: '', type: 'info', active: true, starts_at: '', expires_at: '' };
            this.editorOpen = true;
        },
        toggleActive(ann) { ann.active = !ann.active; },
        deleteAnn(ann) { this.announcements = this.announcements.filter(a => a.id !== ann.id); },
        saveAnn() {
            if (this.editingAnn) { Object.assign(this.editingAnn, this.form); }
            else { this.announcements.push({ id: Date.now(), ...this.form }); }
            this.editorOpen = false; this.editingAnn = null;
        },
    }));
});
</script>
