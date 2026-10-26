@props([
    'locales' => [],
    'translations' => [],
    'class' => '',
])

<?php
$id = 'translations-' . uniqid();
$locales = $locales ?: ['en' => 'English', 'es' => 'Spanish', 'fr' => 'French', 'de' => 'German', 'it' => 'Italian', 'pt' => 'Portuguese'];
$translations = $translations ?: [
    ['key' => 'app.name', 'en' => 'My App', 'es' => 'Mi Aplicación', 'fr' => 'Mon Application'],
    ['key' => 'app.description', 'en' => 'Best app ever', 'es' => 'La mejor aplicación', 'fr' => 'La meilleure application'],
    ['key' => 'nav.home', 'en' => 'Home', 'es' => 'Inicio', 'fr' => 'Accueil'],
    ['key' => 'nav.settings', 'en' => 'Settings', 'es' => 'Configuración', 'fr' => 'Paramètres'],
    ['key' => 'auth.login', 'en' => 'Log In', 'es' => 'Iniciar Sesión', 'fr' => 'Connexion'],
    ['key' => 'auth.register', 'en' => 'Register', 'es' => 'Registrarse', 'fr' => "S'inscrire"],
    ['key' => 'common.save', 'en' => 'Save', 'es' => 'Guardar', 'fr' => 'Enregistrer'],
    ['key' => 'common.delete', 'en' => 'Delete', 'es' => 'Eliminar', 'fr' => 'Supprimer'],
    ['key' => 'common.cancel', 'en' => 'Cancel', 'es' => 'Cancelar', 'fr' => 'Annuler'],
];
?>

<div 
    class="gsmui-translations {{ $class }}"
    x-data="gsmuiTranslations({
        locales: @js($locales),
        translations: @js($translations),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div><h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Translations</h2><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage internationalization strings across locales.</p></div>
            <button @click="addTranslation" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ Add Key</button>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="search" x-model="search" class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Search keys..." />
            </div>
            <template x-for="(label, code) in locales" :key="code">
                <button @click="editLocale = editLocale === code ? '' : code; showAllLocales = true"
                    class="px-3 py-1.5 text-sm rounded-lg border transition-colors"
                    :class="editLocale === code ? 'border-primary bg-primary/10 text-primary' : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-700'"
                    x-text="code.toUpperCase()">
                </button>
            </template>
        </div>

        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                        <tr>
                            <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Key</th>
                            <template x-for="(label, code) in locales" :key="code">
                                <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider" x-show="!editLocale || editLocale === code" x-text="label"></th>
                            </template>
                            <th class="text-right px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        <template x-for="(t, index) in filteredTranslations" :key="index">
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3"><code class="text-sm font-mono text-zinc-800 dark:text-zinc-200" x-text="t.key"></code></td>
                                <template x-for="(label, code) in locales" :key="code">
                                    <td class="px-4 py-3" x-show="!editLocale || editLocale === code">
                                        <input type="text" x-model="t[code]" @input="markDirty(t)" class="w-full px-2 py-1 text-sm border border-transparent hover:border-zinc-300 dark:hover:border-zinc-600 focus:border-primary rounded bg-transparent focus:bg-white dark:focus:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" :placeholder="'Translate to ' + label" />
                                    </td>
                                </template>
                                <td class="px-4 py-3 text-right">
                                    <button @click="deleteTranslation(index)" class="p-1 text-zinc-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <template x-if="filteredTranslations.length === 0">
                <div class="p-8 text-center text-zinc-500"><p>No translation keys found.</p></div>
            </template>
        </div>

        <div class="flex gap-3 justify-end">
            <button @click="exportTranslations" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50">Export JSON</button>
            <button @click="importTranslations" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50">Import JSON</button>
            <input type="file" accept=".json" class="hidden" x-ref="fileInput" @change="handleImport" />
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiTranslations', (config) => ({
        locales: config.locales, translations: config.translations,
        search: '', editLocale: '', dirtyKeys: new Set(),

        get filteredTranslations() {
            if (!this.search) return this.translations;
            const q = this.search.toLowerCase();
            return this.translations.filter(t => t.key.toLowerCase().includes(q) || Object.values(t).some(v => typeof v === 'string' && v.toLowerCase().includes(q)));
        },

        markDirty(t) { this.dirtyKeys.add(t.key); },

        addTranslation() {
            const t = { key: 'new.key' };
            Object.keys(this.locales).forEach(code => t[code] = '');
            this.translations.push(t);
        },

        deleteTranslation(index) { this.translations.splice(index, 1); },

        exportTranslations() {
            const data = { locales: Object.keys(this.locales), translations: this.translations };
            const b = new Blob([JSON.stringify(data, null, 2)], {type:'application/json'});
            const u = URL.createObjectURL(b); const a = document.createElement('a'); a.href=u; a.download='translations.json'; a.click(); URL.revokeObjectURL(u);
        },

        importTranslations() { this.$refs.fileInput.click(); },

        handleImport(e) {
            const file = e.target.files[0]; if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => { try { const d = JSON.parse(ev.target.result); if (d.translations) this.translations = d.translations; } catch {} };
            reader.readAsText(file); e.target.value = '';
        },
    }));
});
</script>
