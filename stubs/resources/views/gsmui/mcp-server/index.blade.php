@props([
    'servers' => [],
    'tools' => [],
    'resources' => [],
    'class' => '',
])

<?php
$id = 'mcp-server-' . uniqid();
$servers = $servers ?: [
    ['id' => 'filesystem', 'name' => 'Filesystem', 'status' => 'connected', 'type' => 'local', 'url' => ''],
    ['id' => 'database', 'name' => 'Database', 'status' => 'connected', 'type' => 'local', 'url' => ''],
    ['id' => 'github', 'name' => 'GitHub', 'status' => 'disconnected', 'type' => 'remote', 'url' => 'https://api.github.com'],
    ['id' => 'slack', 'name' => 'Slack', 'status' => 'error', 'type' => 'remote', 'url' => 'https://slack.com/api'],
];
$tools = $tools ?: [
    ['id' => 'read_file', 'server' => 'filesystem', 'name' => 'Read File', 'description' => 'Read contents of a file', 'parameters' => '{path: string}'],
    ['id' => 'write_file', 'server' => 'filesystem', 'name' => 'Write File', 'description' => 'Write data to a file', 'parameters' => '{path: string, content: string}'],
    ['id' => 'list_dir', 'server' => 'filesystem', 'name' => 'List Directory', 'description' => 'List files in a directory', 'parameters' => '{path: string}'],
    ['id' => 'query', 'server' => 'database', 'name' => 'Execute Query', 'description' => 'Run a SQL query', 'parameters' => '{query: string}'],
];
$resources = $resources ?: [
    ['id' => 'file://{path}', 'server' => 'filesystem', 'name' => 'File Resource', 'description' => 'File system resources', 'type' => 'file'],
    ['id' => 'db://{table}', 'server' => 'database', 'name' => 'Table Resource', 'description' => 'Database table resources', 'type' => 'database'],
];
?>

<div 
    class="gsmui-mcp-server {{ $class }}"
    x-data="gsmuiMcpServer({
        servers: @js($servers),
        tools: @js($tools),
        resources: @js($resources),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">MCP Server Manager</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage Model Context Protocol servers, tools, and resources.</p>
            </div>
            <button @click="showAddServer = true" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm">+ Add Server</button>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="servers.length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Servers</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-emerald-600" x-text="servers.filter(s => s.status === 'connected').length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Connected</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="tools.length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Tools</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="resources.length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Resources</div>
            </div>
        </div>

        <!-- Server List -->
        <section>
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-3">Servers</h3>
            <div class="space-y-2">
                <template x-for="server in servers" :key="server.id">
                    <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-sm transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full" :class="{
                                    'bg-emerald-500': server.status === 'connected',
                                    'bg-zinc-400': server.status === 'disconnected',
                                    'bg-red-500': server.status === 'error'
                                }"></div>
                                <div>
                                    <div class="font-medium text-zinc-900 dark:text-white" x-text="server.name"></div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400" x-text="server.type === 'local' ? 'Local Server' : server.url"></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs px-2 py-0.5 rounded-full capitalize" :class="{
                                    'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400': server.status === 'connected',
                                    'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400': server.status === 'disconnected',
                                    'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400': server.status === 'error'
                                }" x-text="server.status"></span>
                                <button @click="toggleServer(server)" class="px-3 py-1 text-xs rounded-lg transition-colors" :class="server.status === 'connected' ? 'bg-red-50 dark:bg-red-900/20 text-red-600 hover:bg-red-100' : 'bg-primary text-white hover:bg-primary/90'">
                                    <span x-text="server.status === 'connected' ? 'Disconnect' : 'Connect'"></span>
                                </button>
                                <button @click="removeServer(server)" class="p-1 text-zinc-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <!-- Tools -->
        <section>
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-3">Tools</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <template x-for="tool in tools" :key="tool.id">
                    <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-medium text-zinc-900 dark:text-white font-mono text-sm" x-text="tool.name"></div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5" x-text="tool.description"></div>
                            </div>
                            <span class="text-xs px-2 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded text-zinc-600 dark:text-zinc-400 flex-shrink-0" x-text="tool.server"></span>
                        </div>
                        <div class="mt-2 text-xs font-mono text-zinc-400 bg-zinc-50 dark:bg-zinc-900 p-2 rounded overflow-x-auto" x-text="tool.parameters"></div>
                    </div>
                </template>
            </div>
        </section>

        <!-- Add Server Modal -->
        <template x-if="showAddServer">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/30" @click.self="showAddServer = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-md w-full p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Add MCP Server</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Name</label>
                            <input type="text" x-model="newServer.name" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary" placeholder="My Server" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Type</label>
                            <select x-model="newServer.type" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                                <option value="local">Local</option>
                                <option value="remote">Remote</option>
                            </select>
                        </div>
                        <template x-if="newServer.type === 'remote'">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">URL</label>
                                <input type="url" x-model="newServer.url" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary" placeholder="https://..." />
                            </div>
                        </template>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="showAddServer = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700">Cancel</button>
                        <button @click="addServer()" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Add Server</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiMcpServer', (config) => ({
        servers: config.servers,
        tools: config.tools,
        resources: config.resources,
        showAddServer: false,
        newServer: { name: '', type: 'local', url: '' },

        toggleServer(server) {
            server.status = server.status === 'connected' ? 'disconnected' : 'connected';
        },

        removeServer(server) {
            this.servers = this.servers.filter(s => s.id !== server.id);
        },

        addServer() {
            if (!this.newServer.name) return;
            this.servers.push({
                id: this.newServer.name.toLowerCase().replace(/\s+/g, '_'),
                name: this.newServer.name,
                status: 'disconnected',
                type: this.newServer.type,
                url: this.newServer.url,
            });
            this.newServer = { name: '', type: 'local', url: '' };
            this.showAddServer = false;
        },
    }));
});
</script>
