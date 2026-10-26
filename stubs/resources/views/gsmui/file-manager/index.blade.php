@props([
    'directories' => [],
    'files' => [],
    'class' => '',
])

<?php
$id = 'file-manager-' . uniqid();
$directories = $directories ?: ['app', 'config', 'database', 'public', 'resources', 'routes', 'storage', 'tests'];
$files = $files ?: [];
$extensions = ['php', 'js', 'css', 'blade.php', 'json', 'yml', 'md', 'env'];
for ($i = 1; $i <= 15; $i++) {
    $ext = $extensions[array_rand($extensions)];
    $files[] = ['id' => $i, 'name' => "file_{$i}.{$ext}", 'type' => $ext === 'php' || $ext === 'blade.php' ? 'code' : 'file', 'size' => rand(1, 500) . ' KB', 'modified' => '2024-01-' . str_pad(rand(1, 15), 2, '0', STR_PAD_LEFT), 'permissions' => '0644'];
}
?>

<div 
    class="gsmui-file-manager {{ $class }}"
    x-data="gsmuiFileManager({
        directories: @js($directories),
        files: @js($files),
    })"
    id="{{ $id }}"
>
    <div class="flex h-full bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        <!-- Tree sidebar -->
        <aside class="w-56 border-r border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900/50 flex flex-col flex-shrink-0">
            <div class="p-3 border-b border-zinc-200 dark:border-zinc-700">
                <div class="relative"><svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg><input type="search" x-model="search" class="w-full pl-9 pr-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Search files..." /></div>
            </div>
            <div class="flex-1 overflow-y-auto p-2 space-y-0.5">
                <div class="flex items-center gap-2 px-2 py-1.5 rounded-lg bg-primary/10 text-primary font-medium text-sm cursor-pointer" @click="currentPath = '/'; search = ''">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    Root
                </div>
                <template x-for="dir in directories" :key="dir">
                    <div @click="currentPath = '/' + dir" class="flex items-center gap-2 px-2 py-1.5 rounded-lg text-sm cursor-pointer transition-colors"
                        :class="currentPath === '/' + dir ? 'bg-primary/10 text-primary font-medium' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800'">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/></svg>
                        <span x-text="dir"></span>
                    </div>
                </template>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm text-zinc-500">
                    <span class="text-primary font-medium">root</span>
                    <template x-if="currentPath !== '/'">
                        <span><span class="text-zinc-400">/</span><span class="text-zinc-900 dark:text-white font-medium" x-text="currentPath.slice(1)"></span></span>
                    </template>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="showUpload = true" class="px-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700">Upload</button>
                    <button @click="createFile" class="px-3 py-1.5 text-xs bg-primary text-white rounded-lg hover:bg-primary/90">+ New File</button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 sticky top-0">
                        <tr><th class="text-left px-4 py-2 text-xs font-medium text-zinc-500 uppercase tracking-wider">Name</th><th class="text-right px-4 py-2 text-xs font-medium text-zinc-500 uppercase tracking-wider">Size</th><th class="text-right px-4 py-2 text-xs font-medium text-zinc-500 uppercase tracking-wider">Modified</th><th class="text-center px-4 py-2 text-xs font-medium text-zinc-500 uppercase tracking-wider">Permissions</th><th class="text-right px-4 py-2"></th></tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        <template x-for="file in filteredFiles" :key="file.id">
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors cursor-pointer" @click="selectFile(file)">
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        <span class="text-sm text-zinc-900 dark:text-white" x-text="file.name"></span>
                                    </div>
                                </td>
                                <td class="px-4 py-2.5 text-right text-sm text-zinc-500 tabular-nums" x-text="file.size"></td>
                                <td class="px-4 py-2.5 text-right text-sm text-zinc-500" x-text="file.modified"></td>
                                <td class="px-4 py-2.5 text-center"><code class="text-xs font-mono text-zinc-500" x-text="file.permissions"></code></td>
                                <td class="px-4 py-2.5 text-right">
                                    <div class="flex items-center justify-end gap-0.5 opacity-0 group-hover:opacity-100">
                                        <button @click.stop="renameFile(file)" class="p-1 rounded hover:bg-zinc-100 text-zinc-400 hover:text-primary"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                        <button @click.stop="deleteFile(file)" class="p-1 rounded hover:bg-red-50 text-zinc-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <template x-if="filteredFiles.length === 0">
                    <div class="p-8 text-center text-zinc-500"><p>No files in this directory.</p></div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiFileManager', (config) => ({
        directories: config.directories, files: config.files,
        currentPath: '/', search: '',
        selectedFile: null,

        get filteredFiles() {
            let r = this.files;
            if (this.search) { const q = this.search.toLowerCase(); r = r.filter(f => f.name.toLowerCase().includes(q)); }
            return r;
        },
        selectFile(file) { this.selectedFile = file; this.$dispatch('file:selected', { file }); },
        createFile() {
            const name = prompt('File name:');
            if (name) this.files.unshift({ id: Date.now(), name, type: 'file', size: '0 B', modified: new Date().toISOString().slice(0,10), permissions: '0644' });
        },
        renameFile(file) {
            const name = prompt('New name:', file.name);
            if (name) file.name = name;
        },
        deleteFile(file) { if (confirm('Delete ' + file.name + '?')) this.files = this.files.filter(f => f.id !== file.id); },
    }));
});
</script>
