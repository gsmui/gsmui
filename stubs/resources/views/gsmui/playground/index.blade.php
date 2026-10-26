@props([
    'languages' => [],
    'defaultLanguage' => 'blade',
    'initialCode' => '',
    'theme' => 'dark',
    'class' => '',
])

<?php
$id = 'playground-' . uniqid();
$languages = $languages ?: [
    ['id' => 'blade', 'label' => 'Blade', 'icon' => 'code-bracket'],
    ['id' => 'html', 'label' => 'HTML', 'icon' => 'code-bracket'],
    ['id' => 'css', 'label' => 'CSS', 'icon' => 'paint-brush'],
    ['id' => 'javascript', 'label' => 'JavaScript', 'icon' => 'command-line'],
    ['id' => 'alpine', 'label' => 'Alpine.js', 'icon' => 'sparkles'],
    ['id' => 'php', 'label' => 'PHP', 'icon' => 'server'],
    ['id' => 'json', 'label' => 'JSON', 'icon' => 'braces'],
    ['id' => 'markdown', 'label' => 'Markdown', 'icon' => 'document-text'],
];
?>

<div 
    class="gsmui-playground {{ $class }}"
    x-data="gsmuiPlayground({
        languages: @js($languages),
        defaultLanguage: '{{ $defaultLanguage }}',
        initialCode: @js($initialCode),
        theme: '{{ $theme }}',
    })"
    id="{{ $id }}"
>
    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
        <!-- Toolbar -->
        <div class="flex items-center gap-3 p-3 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
            <select x-model="language" class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary">
                <template x-for="lang in languages" :key="lang.id">
                    <option :value="lang.id" x-text="lang.label"></option>
                </template>
            </select>

            <div class="flex-1"></div>

            <button @click="run()" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-lg transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                Run
            </button>
            <button @click="reset()" class="px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">Reset</button>
            <button @click="copyCode()" class="px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">Copy</button>
        </div>

        <!-- Split Editor/Preview -->
        <div class="flex flex-col lg:flex-row" :style="{ minHeight: '400px' }">
            <!-- Editor -->
            <div class="flex-1 border-r border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between px-4 py-2 bg-zinc-100 dark:bg-zinc-800">
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Input</span>
                    <span class="text-xs text-zinc-400" x-text="code.length + ' chars'"></span>
                </div>
                <textarea 
                    x-model="code"
                    @keydown.tab.prevent="insertTab($event)"
                    class="w-full h-full min-h-[300px] p-4 font-mono text-sm bg-zinc-900 text-green-400 dark:bg-black dark:text-green-400 border-none focus:outline-none resize-none"
                    :style="{ fontFamily: "'JetBrains Mono', 'Fira Code', monospace", lineHeight: '1.6', tabSize: '4' }"
                    spellcheck="false"
                    x-ref="editor"
                    :placeholder="'Write your ' + language + ' code here...'"
                ></textarea>
            </div>

            <!-- Preview -->
            <div class="flex-1 flex flex-col">
                <div class="flex items-center justify-between px-4 py-2 bg-zinc-100 dark:bg-zinc-800">
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Output</span>
                    <div class="flex items-center gap-2">
                        <template x-if="running">
                            <span class="text-xs text-amber-500 animate-pulse">Running...</span>
                        </template>
                        <template x-if="error">
                            <span class="text-xs text-red-500">Error</span>
                        </template>
                        <template x-if="!error && output && !running">
                            <span class="text-xs text-emerald-500">Success</span>
                        </template>
                    </div>
                </div>
                <div class="flex-1 p-4 bg-white dark:bg-zinc-900 min-h-[300px] overflow-auto" x-ref="preview">
                    <template x-if="!output && !error">
                        <div class="flex items-center justify-center h-full text-zinc-400 dark:text-zinc-600">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm">Click Run to see output</p>
                            </div>
                        </div>
                    </template>
                    <template x-if="error">
                        <pre class="text-sm text-red-500 whitespace-pre-wrap font-mono" x-text="error"></pre>
                    </template>
                    <template x-if="output && !error">
                        <div class="text-sm" x-html="output"></div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiPlayground', (config) => ({
        languages: config.languages,
        defaultLanguage: config.defaultLanguage,
        initialCode: config.initialCode,
        theme: config.theme,

        language: config.defaultLanguage,
        code: config.initialCode || '<!-- Write your code here -->',
        output: '',
        error: '',
        running: false,

        run() {
            this.running = true;
            this.error = '';
            this.output = '';

            try {
                if (this.language === 'html') {
                    this.output = this.code;
                } else if (this.language === 'javascript') {
                    const logs = [];
                    const mockConsole = { log: (...args) => logs.push(args.map(String).join(' ')) };
                    const fn = new Function('console', this.code);
                    fn(mockConsole);
                    this.output = logs.join('\n') || 'Executed successfully (no output)';
                } else if (this.language === 'json') {
                    const parsed = JSON.parse(this.code);
                    this.output = '<pre class="text-green-600 dark:text-green-400">' + JSON.stringify(parsed, null, 2) + '</pre>';
                } else if (this.language === 'alpine') {
                    this.output = '<div x-data="{ message: \'Hello from Alpine!\' }" class="p-4 bg-zinc-100 dark:bg-zinc-800 rounded-lg"><p x-text="message" class="text-zinc-900 dark:text-white"></p><input x-model="message" class="mt-2 px-3 py-1.5 border rounded w-full" /></div>';
                } else {
                    this.output = `<div class="text-zinc-500 dark:text-zinc-400"><span class="text-primary font-medium">${this.language.toUpperCase()}</span> output preview for:<pre class="mt-2 p-3 bg-zinc-100 dark:bg-zinc-800 rounded text-xs overflow-auto">${this.escapeHtml(this.code)}</pre></div>`;
                }
            } catch (e) {
                this.error = e.message || 'An error occurred';
            }

            this.running = false;
        },

        reset() {
            this.code = this.initialCode || '<!-- Write your code here -->';
            this.output = '';
            this.error = '';
        },

        copyCode() {
            navigator.clipboard.writeText(this.code).catch(() => {
                const ta = document.createElement('textarea');
                ta.value = this.code;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
            });
        },

        insertTab(event) {
            const ta = event.target;
            const start = ta.selectionStart;
            const end = ta.selectionEnd;
            this.code = this.code.substring(0, start) + '    ' + this.code.substring(end);
            this.$nextTick(() => {
                ta.selectionStart = ta.selectionEnd = start + 4;
            });
        },

        escapeHtml(str) {
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        },
    }));
});
</script>

<style>
.gsmui-playground textarea::placeholder {
    @apply text-zinc-600;
}
</style>
