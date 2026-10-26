<x-layouts.marketing>
    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4">
            <h1 class="text-4xl font-bold text-center text-zinc-900 dark:text-white mb-12">Documentation</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1">
                    <nav class="space-y-2">
                        <div class="pb-4">
                            <h4 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-2">Getting Started</h4>
                            <a href="#installation" class="block px-3 py-2 text-sm rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white">Installation</a>
                            <a href="#quick-start" class="block px-3 py-2 text-sm rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">Quick Start</a>
                            <a href="#theming" class="block px-3 py-2 text-sm rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">Theming</a>
                        </div>
                        <div class="pb-4">
                            <h4 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-2">Components</h4>
                            <a href="#button" class="block px-3 py-2 text-sm rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">Button</a>
                            <a href="#input" class="block px-3 py-2 text-sm rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">Input</a>
                            <a href="#card" class="block px-3 py-2 text-sm rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">Card</a>
                            <a href="#modal" class="block px-3 py-2 text-sm rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">Modal</a>
                        </div>
                    </nav>
                </div>
                <div class="md:col-span-2">
                    <div class="prose prose-zinc dark:prose-invert max-w-none">
                        <h2 id="installation">Installation</h2>
                        <p>Install GsmUi Pro using Composer:</p>
                        <pre><code>composer require gsmui/gsmui-pro</code></pre>
                        <p>Publish the configuration:</p>
                        <pre><code>php artisan vendor:publish --tag=gsmui-pro-config</code></pre>
                        <h2 id="quick-start">Quick Start</h2>
                        <p>Add the GsmUi CSS to your layout:</p>
                        <pre><code>@vite(['resources/css/app.css'])</code></pre>
                        <p>Use components in your Blade templates:</p>
                        <pre><code>&lt;x-gsmui::button variant="primary"&gt;
    Click me
&lt;/x-gsmui::button&gt;</code></pre>
                        <h2 id="theming">Theming</h2>
                        <p>GsmUi uses CSS custom properties for theming. Define your theme in the config:</p>
                        <pre><code>// config/gsmui.php
return [
    'theme' => [
        'primary' => '#7354f1',
        'background' => '#ffffff',
    ],
];</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.marketing>
