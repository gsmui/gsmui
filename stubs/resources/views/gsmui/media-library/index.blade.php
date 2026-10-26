@props([
    'items' => [],
    'folders' => [],
    'accept' => 'image/*,.pdf,.doc,.docx',
    'maxSize' => 10,
    'class' => '',
])

<?php
$id = 'media-library-' . uniqid();
$folders = $folders ?: ['Images', 'Documents', 'Videos', 'Assets'];
$items = $items ?: [];
for ($i = 1; $i <= 12; $i++) {
    $items[] = ['id' => $i, 'name' => "file_{$i}.png", 'type' => 'image', 'size' => rand(10, 500) . ' KB', 'folder' => $folders[array_rand($folders)], 'date' => '2024-01-' . str_pad($i, 2, '0', STR_PAD_LEFT)];
}
?>

<div 
    class="gsmui-media-library {{ $class }}"
    x-data="gsmuiMediaLibrary({
        items: @js($items),
        folders: @js($folders),
        accept: '{{ $accept }}',
        maxSize: @js($maxSize),
    })"
    id="{{ $id }}"
>
    <div class="space-y-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Media Library</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5" x-text="items.length + ' files'"></p>
            </div>
            <div class="flex items-center gap-2">
                <button @click="viewMode = 'grid'" class="p-2 rounded-lg transition-colors" :class="viewMode === 'grid' ? 'bg-primary/10 text-primary' : 'hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-500'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </button>
                <button @click="viewMode = 'list'" class="p-2 rounded-lg transition-colors" :class="viewMode === 'list' ? 'bg-primary/10 text-primary' : 'hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-500'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <label class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm cursor-pointer flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    Upload
                    <input type="file" multiple :accept="accept" class="hidden" @change="uploadFiles($event)" />
                </label>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="search" x-model="search" class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Search files..." />
            </div>
            <select x-model="filterFolder" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                <option value="">All Folders</option>
                <template x-for="folder in folders" :key="folder">
                    <option :value="folder" x-text="folder"></option>
                </template>
            </select>
            <select x-model="sortBy" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                <option value="name">Name</option>
                <option value="date">Date</option>
                <option value="size">Size</option>
            </select>
        </div>

        <!-- Grid View -->
        <template x-if="viewMode === 'grid'">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <template x-for="item in filteredItems" :key="item.id">
                    <div @click="selectItem(item)" class="group relative rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden hover:shadow-md transition-shadow cursor-pointer"
                        :class="{ 'ring-2 ring-primary': selectedIds.includes(item.id) }">
                        <div class="aspect-square bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-700 dark:to-zinc-800 flex items-center justify-center">
                            <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="p-2">
                            <p class="text-xs font-medium text-zinc-900 dark:text-white truncate" x-text="item.name"></p>
                            <p class="text-[10px] text-zinc-400" x-text="item.size"></p>
                        </div>
                        <button @click.stop="deleteItem(item)" class="absolute top-1 right-1 p-1 bg-white dark:bg-zinc-800 rounded-full shadow opacity-0 group-hover:opacity-100 transition-opacity hover:text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </template>

        <!-- List View -->
        <template x-if="viewMode === 'list'">
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                        <tr><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Name</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Folder</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Size</th><th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Date</th><th class="text-right px-4 py-3"></th></tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        <template x-for="item in filteredItems" :key="item.id">
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors cursor-pointer" @click="selectItem(item)">
                                <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-white" x-text="item.name"></td>
                                <td class="px-4 py-3 text-sm text-zinc-500" x-text="item.folder"></td>
                                <td class="px-4 py-3 text-sm text-zinc-500" x-text="item.size"></td>
                                <td class="px-4 py-3 text-sm text-zinc-500" x-text="item.date"></td>
                                <td class="px-4 py-3 text-right"><button @click.stop="deleteItem(item)" class="p-1 text-zinc-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </template>

        <!-- Empty -->
        <template x-if="filteredItems.length === 0">
            <div class="text-center py-16 text-zinc-500 dark:text-zinc-400">
                <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p>No files found</p>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiMediaLibrary', (config) => ({
        items: config.items,
        folders: config.folders,
        accept: config.accept,
        maxSize: config.maxSize,
        viewMode: 'grid',
        search: '',
        filterFolder: '',
        sortBy: 'name',
        selectedIds: [],

        get filteredItems() {
            let result = [...this.items];
            if (this.filterFolder) result = result.filter(i => i.folder === this.filterFolder);
            if (this.search) { const q = this.search.toLowerCase(); result = result.filter(i => i.name.toLowerCase().includes(q)); }
            result.sort((a, b) => a[this.sortBy]?.toString().localeCompare(b[this.sortBy]?.toString()));
            return result;
        },

        selectItem(item) {
            const idx = this.selectedIds.indexOf(item.id);
            if (idx >= 0) this.selectedIds.splice(idx, 1);
            else this.selectedIds.push(item.id);
        },

        deleteItem(item) {
            this.items = this.items.filter(i => i.id !== item.id);
            this.selectedIds = this.selectedIds.filter(id => id !== item.id);
        },

        uploadFiles(event) {
            const files = Array.from(event.target.files);
            files.forEach(file => {
                this.items.push({
                    id: Date.now() + Math.random(),
                    name: file.name,
                    type: file.type.split('/')[0],
                    size: (file.size / 1024).toFixed(0) + ' KB',
                    folder: 'Uploads',
                    date: new Date().toISOString().slice(0, 10),
                });
            });
            event.target.value = '';
        },
    }));
});
</script>
