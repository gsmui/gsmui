@props([
    'endpoints' => [],
    'baseUrl' => '/api',
    'class' => '',
])

<?php
$id = 'api-layer-' . uniqid();
$endpoints = $endpoints ?: [
    ['method' => 'GET', 'path' => '/users', 'description' => 'List all users', 'auth' => 'Bearer', 'params' => [['name' => 'page', 'type' => 'integer', 'required' => false], ['name' => 'per_page', 'type' => 'integer', 'required' => false]]],
    ['method' => 'POST', 'path' => '/users', 'description' => 'Create a new user', 'auth' => 'Bearer', 'params' => [['name' => 'name', 'type' => 'string', 'required' => true], ['name' => 'email', 'type' => 'string', 'required' => true]]],
    ['method' => 'GET', 'path' => '/users/{id}', 'description' => 'Get user by ID', 'auth' => 'Bearer', 'params' => [['name' => 'id', 'type' => 'integer', 'required' => true]]],
    ['method' => 'PUT', 'path' => '/users/{id}', 'description' => 'Update a user', 'auth' => 'Bearer', 'params' => []],
    ['method' => 'DELETE', 'path' => '/users/{id}', 'description' => 'Delete a user', 'auth' => 'Bearer', 'params' => []],
];
?>

<div 
    class="gsmui-api-layer {{ $class }}"
    x-data="gsmuiApiLayer({
        endpoints: @js($endpoints),
        baseUrl: '{{ $baseUrl }}',
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">API Explorer</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Browse and test API endpoints.</p>
            </div>
            <div class="text-sm px-3 py-1.5 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-zinc-600 dark:text-zinc-400 font-mono" x-text="baseUrl"></div>
        </div>

        <!-- Endpoint List -->
        <div class="space-y-3">
            <template x-for="(ep, index) in endpoints" :key="index">
                <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
                    <div @click="expandedEndpoint = expandedEndpoint === index ? null : index" class="flex items-center gap-3 p-4 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase"
                            :class="{
                                'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400': ep.method === 'GET',
                                'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400': ep.method === 'POST',
                                'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400': ep.method === 'PUT',
                                'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400': ep.method === 'DELETE'
                            }"
                            x-text="ep.method">
                        </span>
                        <code class="flex-1 text-sm font-mono text-zinc-900 dark:text-white" x-text="ep.path"></code>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400 flex-1" x-text="ep.description"></span>
                        <svgg class="w-5 h-5 text-zinc-400 transition-transform" :class="{ 'rotate-180': expandedEndpoint === index }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>

                    <template x-if="expandedEndpoint === index">
                        <div class="px-4 pb-4 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="pt-4 space-y-4">
                                <!-- Auth -->
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="text-zinc-500 dark:text-zinc-400">Authentication:</span>
                                    <span class="px-2 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded text-xs font-mono" x-text="ep.auth || 'None'"></span>
                                </div>

                                <!-- Parameters -->
                                <template x-if="ep.params && ep.params.length > 0">
                                    <div>
                                        <h4 class="text-sm font-medium text-zinc-900 dark:text-white mb-2">Parameters</h4>
                                        <div class="space-y-2">
                                            <template x-for="(param, pi) in ep.params" :key="pi">
                                                <div class="flex items-center gap-3 text-sm">
                                                    <code class="font-mono text-zinc-800 dark:text-zinc-200 w-32" x-text="param.name"></code>
                                                    <span class="text-xs text-zinc-400 w-20" x-text="param.type"></span>
                                                    <span class="text-xs" :class="param.required ? 'text-red-500' : 'text-zinc-400'" x-text="param.required ? 'required' : 'optional'"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <!-- Try It -->
                                <div>
                                    <h4 class="text-sm font-medium text-zinc-900 dark:text-white mb-2">Try It</h4>
                                    <div class="flex items-center gap-2">
                                        <input type="text" x-model="testParams" class="flex-1 px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 font-mono focus:outline-none focus:ring-1 focus:ring-primary" placeholder='{"key": "value"}' />
                                        <button @click="testEndpoint(ep)" class="px-4 py-2 bg-primary text-white text-sm rounded-lg hover:bg-primary/90 transition-colors">Send</button>
                                    </div>
                                </div>

                                <!-- Response -->
                                <template x-if="testResponse !== null && testEndpointIndex === index">
                                    <div>
                                        <h4 class="text-sm font-medium text-zinc-900 dark:text-white mb-2">Response</h4>
                                        <pre class="p-3 bg-zinc-900 text-green-400 rounded-lg text-xs overflow-auto max-h-48" x-text="testResponse"></pre>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiApiLayer', (config) => ({
        endpoints: config.endpoints,
        baseUrl: config.baseUrl,
        expandedEndpoint: null,
        testParams: '',
        testResponse: null,
        testEndpointIndex: null,

        async testEndpoint(ep) {
            this.testEndpointIndex = this.endpoints.indexOf(ep);
            this.testResponse = 'Sending request...';

            try {
                const url = this.baseUrl + ep.path.replace(/\{(\w+)\}/g, (_, p) => {
                    try { const params = JSON.parse(this.testParams || '{}'); return params[p] || p; }
                    catch { return p; }
                });

                const options = { method: ep.method, headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' } };
                if (['POST', 'PUT'].includes(ep.method) && this.testParams) {
                    try { options.body = this.testParams; } catch {}
                }

                const res = await fetch(url, options);
                const text = await res.text();
                try { this.testResponse = JSON.stringify(JSON.parse(text), null, 2); }
                catch { this.testResponse = text; }
            } catch (e) {
                this.testResponse = 'Error: ' + (e.message || 'Network error');
            }
        },
    }));
});
</script>
