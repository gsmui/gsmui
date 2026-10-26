# 17 - Playground

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The Playground is an interactive environment where developers can compose GsmUi components in real-time, experiment with props, and export working code.

---

# Vision

Provide the fastest way to explore, test, and prototype with GsmUi components — no local setup required.

---

# Core Features

## Code Editor

* Syntax highlighting
* Auto-completion
* Error detection
* Multi-file support
* Code formatting

## Live Preview

* Real-time rendering
* Responsive preview modes
* Dark/light theme toggle
* Device frames (desktop/tablet/mobile)

## Component Palette

* Searchable component list
* Drag-and-drop
* Component categories
* Props panel
* Event panel

## Export Options

* Blade code
* Livewire component
* Full page export
* Download as ZIP
* Copy to clipboard

---

# Playground Layout

```text
┌─────────────────────────────────────────────────────┐
│ GsmUi Playground                          [Export ▼] │
├───────────┬─────────────────────────────────────────┤
│           │                                         │
│ Components│        Preview Area                     │
│           │                                         │
│ Search    │  ┌─────────────────────────────────┐   │
│ ─────────│  │                                 │   │
│ Actions  │  │     Rendered Components          │   │
│ Forms    │  │                                 │   │
│ Layout   │  │                                 │   │
│ Nav      │  └─────────────────────────────────┘   │
│ Data     │                                         │
│ Feedback ├─────────────────────────────────────────┤
│ Overlays │                                         │
│ Media    │        Code Editor                       │
│ Charts   │  ┌─────────────────────────────────┐   │
│          │  │ @extends('layouts.app')          │   │
│          │  │                                  │   │
│          │  │ <x-gsm-button variant="primary"> │   │
│          │  │     Click me                     │   │
│          │  │ </x-gsm-button>                  │   │
│          │  └─────────────────────────────────┘   │
│          │                                         │
│ Props    │  [Blade] [Livewire] [Alpine]            │
│ ─────────│                                         │
│ variant  │                                         │
│ size     │                                         │
│ color    │                                         │
└───────────┴─────────────────────────────────────────┘
```

---

# Component Interaction

## Adding Components

1. Browse component palette
2. Click or drag to add
3. Component appears in preview
4. Code updates automatically

## Modifying Props

1. Select component in preview
2. Props panel shows available options
3. Modify values
4. Preview updates in real-time
5. Code updates accordingly

## Nesting Components

1. Drag component into container
2. Components nest automatically
3. Layout adjusts
4. Code reflects hierarchy

---

# Code Generation

## Blade Output

```blade
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <x-gsm-card>
            <x-gsm-card-header>
                <h2 class="text-xl font-semibold">
                    Hello World
                </h2>
            </x-gsm-card-header>
            <x-gsm-card-body>
                <p>Welcome to GsmUi</p>
            </x-gsm-card-body>
        </x-gsm-card>
    </div>
@endsection
```

## Livewire Output

```php
<?php

namespace App\Livewire;

use Livewire\Component;

class HelloWorld extends Component
{
    public $message = 'Welcome to GsmUi';

    public function render()
    {
        return view('livewire.hello-world');
    }
}
```

```blade
<div>
    <x-gsm-card>
        <x-gsm-card-body>
            <p>{{ $message }}</p>
        </x-gsm-card-body>
    </x-gsm-card>
</div>
```

---

# State Management

## Local State

```javascript
// Alpine.js state
Alpine.data('playground', () => ({
    components: [],
    selectedComponent: null,
    
    addComponent(type) {
        this.components.push({
            type,
            props: this.getDefaultProps(type)
        });
    },
    
    removeComponent(index) {
        this.components.splice(index, 1);
    }
}));
```

## Persistence

* Save playground state to URL
* Save to user account
* Load from templates
* Share playground links

---

# Templates

## Starter Templates

* Blank canvas
* Landing page
* Dashboard
* Auth pages
* Forms
* Data table

## Community Templates

* User-submitted layouts
* Featured compositions
* Component examples

---

# Features Panel

## Props Editor

```text
Button Props
────────────
variant: [primary ▼]
size: [md ▼]
color: [blue ▼]
disabled: [ ] disabled
loading: [ ] loading
icon: [plus ▼]
```

## Events Panel

```text
Events
──────
@click: handle click
@mouseenter: handle hover
@focus: handle focus
```

## Slots Panel

```text
Slots
─────
icon: Icon slot
default: Button text
```

---

# Performance Optimization

* Lazy component loading
* Virtual scrolling for large layouts
* Debounced preview updates
* Cached component metadata
* Optimized code generation

---

# Collaboration Features

* Share playground links
* Real-time collaboration (future)
* Comment on code
* Fork playground sessions
* Version history

---

# Technical Architecture

```text
Frontend
├── Monaco Editor (code editing)
├── GsmUi Components (preview)
├── Livewire (state management)
└── Alpine.js (UI interactions)

Backend
├── Playground Service
├── Code Parser
├── Component Registry
├── Template Storage
└── Analytics

Storage
├── Playground sessions (Redis)
├── Templates (Database)
├── Shared links (Database)
└── Analytics (Database)
```

---

# Database Schema

Key tables:

* `playground_sessions` — Saved sessions
* `playground_templates` — Starter templates
* `playground_shares` — Shared links
* `playground_analytics` — Usage data

---

# Security

* Sandboxed preview iframe
* No server-side code execution
* Rate limiting on saves
* Input sanitization
* No file uploads

---

# Admin Features

* Template management
* Analytics dashboard
* Featured templates
* Usage statistics
* Performance monitoring

---

# Success Metrics

* 10,000+ playground sessions/month
* <500ms preview render time
* 70%+ code export usage
* 50+ community templates
* 4.5+ user satisfaction rating

---

# Detailed Code Editor Implementation

## Monaco Editor Integration

```javascript
class PlaygroundEditor {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.editor = null;
        this.previewFrame = null;
        this.debounceTimer = null;
        
        this.init();
    }
    
    init() {
        // Configure Monaco Editor
        require.config({ 
            paths: { 
                'vs': 'https://cdn.jsdelivr.net/npm/monaco-editor@0.45.0/min/vs' 
            } 
        });
        
        require(['vs/editor/editor.main'], () => {
            this.editor = monaco.editor.create(this.container, {
                value: this.getDefaultCode(),
                language: 'html',
                theme: 'vs-dark',
                minimap: { enabled: false },
                fontSize: 14,
                lineNumbers: 'on',
                roundedSelection: false,
                scrollBeyondLastLine: false,
                automaticLayout: true,
                tabSize: 2,
                wordWrap: 'on',
                formatOnPaste: true,
                formatOnType: true,
                suggestOnTriggerCharacters: true,
                quickSuggestions: true,
            });
            
            // Register Blade language
            this.registerBladeLanguage();
            
            // Setup event listeners
            this.setupEventListeners();
            
            // Load component snippets
            this.loadSnippets();
        });
    }
    
    registerBladeLanguage() {
        monaco.languages.register({ id: 'blade' });
        
        monaco.languages.setMonarchTokensProvider('blade', {
            tokenizer: {
                root: [
                    [/\{\{.*?\}\}/, 'variable'],
                    [/@\w+/, 'keyword'],
                    [/<\/?[\w-]+/, 'tag'],
                    [/->[\w]+/, 'method'],
                ],
            },
        });
    }
    
    setupEventListeners() {
        this.editor.onDidChangeModelContent(() => {
            this.debounceUpdate();
        });
        
        // Keyboard shortcuts
        this.editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.KeyS, () => {
            this.saveToClipboard();
        });
        
        this.editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.Enter, () => {
            this.updatePreview();
        });
    }
    
    debounceUpdate() {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(() => {
            this.updatePreview();
        }, 300);
    }
    
    updatePreview() {
        const code = this.editor.getValue();
        
        // Send to preview iframe
        this.previewFrame.contentWindow.postMessage({
            type: 'update',
            code: code
        }, '*');
        
        // Update URL state
        this.updateUrlState(code);
    }
    
    loadSnippets() {
        const snippets = {
            'button': `<x-gsm-button variant="primary">\n    Click me\n</x-gsm-button>`,
            'input': `<x-gsm-input\n    wire:model="name"\n    label="Name"\n    placeholder="Enter your name"\n/>`,
            'card': `<x-gsm-card>\n    <x-gsm-card-header>\n        <h2 class="text-lg font-semibold">Title</h2>\n    </x-gsm-card-header>\n    <x-gsm-card-body>\n        <p>Content here</p>\n    </x-gsm-card-body>\n</x-gsm-card>`,
            'alert': `<x-gsm-alert type="info">\n    This is an informational message.\n</x-gsm-alert>`,
            'badge': `<x-gsm-badge color="blue">New</x-gsm-badge>`,
        };
        
        monaco.languages.registerCompletionItemProvider('blade', {
            provideCompletionItems: (model, position) => {
                const suggestions = Object.entries(snippets).map(([key, value]) => ({
                    label: `gsm:${key}`,
                    kind: monaco.languages.CompletionItemKind.Snippet,
                    insertText: value,
                    insertTextRules: monaco.languages.CompletionItemInsertTextRule.InsertAsSnippet,
                    documentation: `Insert ${key} component`,
                }));
                
                return { suggestions };
            },
        });
    }
}
```

## Preview Iframe System

```javascript
class PreviewRenderer {
    constructor(iframeId) {
        this.iframe = document.getElementById(iframeId);
        this.sandboxedDoc = null;
        
        this.init();
    }
    
    init() {
        // Listen for messages from editor
        window.addEventListener('message', (event) => {
            if (event.data.type === 'update') {
                this.render(event.data.code);
            }
        });
        
        // Setup iframe
        this.setupIframe();
    }
    
    setupIframe() {
        const html = `
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="/css/gsmui.css">
                <style>
                    body {
                        margin: 0;
                        padding: 16px;
                        font-family: system-ui, sans-serif;
                        background: var(--gsm-bg, white);
                        color: var(--gsm-text, #1f2937);
                    }
                    .error {
                        background: #fef2f2;
                        border: 1px solid #fecaca;
                        border-radius: 8px;
                        padding: 16px;
                        color: #991b1b;
                    }
                </style>
            </head>
            <body id="preview-content">
                <p>Loading preview...</p>
                <script src="/js/gsmui.js"><\/script>
                <script>
                    // Listen for updates
                    window.addEventListener('message', (event) => {
                        if (event.data.type === 'update') {
                            renderCode(event.data.code);
                        }
                    });
                    
                    function renderCode(code) {
                        const container = document.getElementById('preview-content');
                        try {
                            container.innerHTML = code;
                            // Re-initialize components
                            if (window.GsmUi) {
                                window.GsmUi.init(container);
                            }
                        } catch (error) {
                            container.innerHTML = '<div class="error">' + error.message + '</div>';
                        }
                    }
                <\/script>
            </body>
            </html>
        `;
        
        this.iframe.srcdoc = html;
    }
    
    render(code) {
        this.iframe.contentWindow.postMessage({
            type: 'update',
            code: code
        }, '*');
    }
    
    setTheme(theme) {
        this.iframe.contentWindow.postMessage({
            type: 'theme',
            theme: theme
        }, '*');
    }
    
    setViewport(viewport) {
        const widths = {
            desktop: '100%',
            tablet: '768px',
            mobile: '375px'
        };
        
        this.iframe.style.maxWidth = widths[viewport];
        this.iframe.style.margin = viewport !== 'desktop' ? '0 auto' : '0';
    }
}
```

---

# Preview System Details

## Component Rendering Pipeline

```php
class PreviewRenderer
{
    public function render(string $code, array $context = []): PreviewResult
    {
        try {
            // Parse Blade template
            $compiled = $this->compileBlade($code);
            
            // Create sandbox environment
            $sandbox = $this->createSandbox($context);
            
            // Execute in sandbox
            $html = $this->executeInSandbox($compiled, $sandbox);
            
            // Sanitize output
            $sanitized = $this->sanitize($html);
            
            return new PreviewResult(true, $sanitized);
            
        } catch (\Exception $e) {
            return new PreviewResult(false, null, $e->getMessage());
        }
    }
    
    private function compileBlade(string $code): string
    {
        $compiler = new Compiler(app('blade.compiler'));
        
        return $compiler->compileString($code);
    }
    
    private function createSandbox(array $context): SandboxedEnvironment
    {
        $sandbox = new SandboxedEnvironment();
        
        // Add GsmUi components
        $sandbox->registerComponents();
        
        // Add context variables
        foreach ($context as $key => $value) {
            $sandbox->setVariable($key, $value);
        }
        
        // Disable dangerous functions
        $sandbox->disableFunctions(['exec', 'system', 'passthru', 'shell_exec']);
        
        return $sandbox;
    }
    
    private function executeInSandbox(string $compiled, SandboxedEnvironment $sandbox): string
    {
        return $sandbox->execute($compiled);
    }
    
    private function sanitize(string $html): string
    {
        // Remove script tags
        $html = preg_replace('/<script\b[^>]*(?!type="text\/x-template)[^>]*>.*?<\/script>/is', '', $html);
        
        // Remove event handlers
        $html = preg_replace('/\bon\w+\s*=\s*["\'][^"\']*["\']/i', '', $html);
        
        // Remove javascript: URLs
        $html = preg_replace('/javascript\s*:/i', '', $html);
        
        return $html;
    }
}
```

## Responsive Preview Modes

```php
class ResponsivePreview
{
    private const VIEWPORTS = [
        'desktop' => [
            'width' => 1920,
            'height' => 1080,
            'label' => 'Desktop',
        ],
        'laptop' => [
            'width' => 1366,
            'height' => 768,
            'label' => 'Laptop',
        ],
        'tablet' => [
            'width' => 768,
            'height' => 1024,
            'label' => 'Tablet',
        ],
        'mobile' => [
            'width' => 375,
            'height' => 812,
            'label' => 'Mobile',
        ],
    ];
    
    public function getViewport(string $name): array
    {
        return self::VIEWPORTS[$name] ?? self::VIEWPORTS['desktop'];
    }
    
    public function getAllViewports(): array
    {
        return self::VIEWPORTS;
    }
    
    public function renderForViewport(string $code, string $viewport): string
    {
        $vp = $this->getViewport($viewport);
        
        return <<<HTML
        <div class="viewport-frame" style="width: {$vp['width']}px; max-width: 100%; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
            <div class="viewport-header" style="background: #f3f4f6; padding: 8px 16px; border-bottom: 1px solid #e5e7eb; font-size: 12px; color: #6b7280;">
                {$vp['label']} ({$vp['width']} x {$vp['height']})
            </div>
            <div class="viewport-content" style="width: {$vp['width']}px; height: {$vp['height']}px; overflow: auto;">
                {$code}
            </div>
        </div>
        HTML;
    }
}
```

---

# Component Palette Details

## Component Registry

```php
class ComponentRegistry
{
    private array $components = [];
    
    public function __construct()
    {
        $this->registerComponents();
    }
    
    private function registerComponents(): void
    {
        $categories = [
            'actions' => [
                'button' => [
                    'name' => 'Button',
                    'description' => 'Interactive button component',
                    'props' => [
                        'variant' => ['primary', 'secondary', 'danger', 'ghost'],
                        'size' => ['sm', 'md', 'lg'],
                        'disabled' => 'boolean',
                        'loading' => 'boolean',
                    ],
                    'slots' => ['default', 'icon'],
                    'events' => ['click'],
                ],
                'icon-button' => [
                    'name' => 'Icon Button',
                    'description' => 'Button with icon only',
                    'props' => [
                        'icon' => 'string',
                        'size' => ['sm', 'md', 'lg'],
                    ],
                    'slots' => ['icon'],
                    'events' => ['click'],
                ],
            ],
            'forms' => [
                'input' => [
                    'name' => 'Input',
                    'description' => 'Text input field',
                    'props' => [
                        'type' => ['text', 'email', 'password', 'number'],
                        'label' => 'string',
                        'placeholder' => 'string',
                        'disabled' => 'boolean',
                        'error' => 'string',
                    ],
                    'slots' => ['prefix', 'suffix'],
                    'events' => ['input', 'change', 'focus', 'blur'],
                ],
                'select' => [
                    'name' => 'Select',
                    'description' => 'Dropdown select',
                    'props' => [
                        'options' => 'array',
                        'label' => 'string',
                        'placeholder' => 'string',
                        'multiple' => 'boolean',
                    ],
                    'slots' => ['default'],
                    'events' => ['change'],
                ],
            ],
            'layout' => [
                'card' => [
                    'name' => 'Card',
                    'description' => 'Container card',
                    'props' => [
                        'padding' => ['none', 'sm', 'md', 'lg'],
                        'shadow' => ['none', 'sm', 'md', 'lg'],
                    ],
                    'slots' => ['header', 'default', 'footer'],
                    'events' => [],
                ],
            ],
        ];
        
        $this->components = $categories;
    }
    
    public function getCategories(): array
    {
        return array_keys($this->components);
    }
    
    public function getComponentsByCategory(string $category): array
    {
        return $this->components[$category] ?? [];
    }
    
    public function getComponent(string $name): ?array
    {
        foreach ($this->components as $category => $components) {
            if (isset($components[$name])) {
                return $components[$name];
            }
        }
        
        return null;
    }
    
    public function searchComponents(string $query): array
    {
        $results = [];
        
        foreach ($this->components as $category => $components) {
            foreach ($components as $slug => $component) {
                if (str_contains(strtolower($component['name']), strtolower($query)) ||
                    str_contains(strtolower($component['description']), strtolower($query))) {
                    $results[] = array_merge($component, [
                        'slug' => $slug,
                        'category' => $category,
                    ]);
                }
            }
        }
        
        return $results;
    }
}
```

## Drag and Drop System

```javascript
class DragDropManager {
    constructor(palette, preview) {
        this.palette = palette;
        this.preview = preview;
        this.draggedComponent = null;
        
        this.init();
    }
    
    init() {
        // Setup palette drag handlers
        this.palette.querySelectorAll('.component-item').forEach(item => {
            item.setAttribute('draggable', 'true');
            
            item.addEventListener('dragstart', (e) => {
                this.draggedComponent = e.target.dataset.component;
                e.dataTransfer.effectAllowed = 'copy';
            });
            
            item.addEventListener('dragend', () => {
                this.draggedComponent = null;
            });
        });
        
        // Setup preview drop zone
        this.preview.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'copy';
            this.preview.classList.add('drag-over');
        });
        
        this.preview.addEventListener('dragleave', () => {
            this.preview.classList.remove('drag-over');
        });
        
        this.preview.addEventListener('drop', (e) => {
            e.preventDefault();
            this.preview.classList.remove('drag-over');
            
            if (this.draggedComponent) {
                this.addComponent(this.draggedComponent);
            }
        });
    }
    
    addComponent(componentType) {
        const code = this.generateComponentCode(componentType);
        
        // Insert at cursor or append
        const editor = window.playgroundEditor;
        const position = editor.getPosition();
        
        editor.executeEdits('drag-drop', [{
            range: new monaco.Range(
                position.lineNumber,
                position.column,
                position.lineNumber,
                position.column
            ),
            text: code,
            forceMoveMarkers: true,
        }]);
    }
    
    generateComponentCode(type) {
        const templates = {
            'button': '<x-gsm-button variant="primary">\n    Click me\n</x-gsm-button>',
            'input': '<x-gsm-input\n    wire:model="field"\n    label="Label"\n/>',
            'card': '<x-gsm-card>\n    <x-gsm-card-body>\n        Content\n    </x-gsm-card-body>\n</x-gsm-card>',
        };
        
        return templates[type] || `<!-- ${type} -->`;
    }
}
```

---

# State Management Details

## Playground State

```javascript
class PlaygroundState {
    constructor() {
        this.state = {
            components: [],
            selectedComponent: null,
            theme: 'light',
            viewport: 'desktop',
            code: '',
            history: [],
            historyIndex: -1,
        };
        
        this.listeners = [];
    }
    
    getState() {
        return { ...this.state };
    }
    
    setState(updates) {
        this.state = { ...this.state, ...updates };
        this.notifyListeners();
    }
    
    subscribe(listener) {
        this.listeners.push(listener);
        
        return () => {
            this.listeners = this.listeners.filter(l => l !== listener);
        };
    }
    
    notifyListeners() {
        this.listeners.forEach(listener => listener(this.state));
    }
    
    // History management
    pushHistory(code) {
        // Remove future history if we're in the middle
        if (this.state.historyIndex < this.state.history.length - 1) {
            this.state.history = this.state.history.slice(0, this.state.historyIndex + 1);
        }
        
        this.state.history.push(code);
        this.state.historyIndex = this.state.history.length - 1;
        
        this.notifyListeners();
    }
    
    undo() {
        if (this.state.historyIndex > 0) {
            this.state.historyIndex--;
            this.state.code = this.state.history[this.state.historyIndex];
            this.notifyListeners();
        }
    }
    
    redo() {
        if (this.state.historyIndex < this.state.history.length - 1) {
            this.state.historyIndex++;
            this.state.code = this.state.history[this.state.historyIndex];
            this.notifyListeners();
        }
    }
    
    // Persistence
    save() {
        const data = {
            code: this.state.code,
            theme: this.state.theme,
            viewport: this.state.viewport,
            timestamp: Date.now(),
        };
        
        localStorage.setItem('playground_state', JSON.stringify(data));
    }
    
    load() {
        const data = localStorage.getItem('playground_state');
        
        if (data) {
            const parsed = JSON.parse(data);
            this.setState({
                code: parsed.code,
                theme: parsed.theme,
                viewport: parsed.viewport,
            });
        }
    }
    
    // URL state
    saveToUrl() {
        const params = new URLSearchParams();
        params.set('code', btoa(this.state.code));
        params.set('theme', this.state.theme);
        params.set('viewport', this.state.viewport);
        
        window.history.replaceState({}, '', `${window.location.pathname}?${params.toString()}`);
    }
    
    loadFromUrl() {
        const params = new URLSearchParams(window.location.search);
        
        if (params.has('code')) {
            this.setState({
                code: atob(params.get('code')),
                theme: params.get('theme') || 'light',
                viewport: params.get('viewport') || 'desktop',
            });
        }
    }
}
```

## State Persistence

```php
class PlaygroundPersistence
{
    public function saveSession(User $user, array $data): PlaygroundSession
    {
        return PlaygroundSession::create([
            'user_id' => $user->id,
            'code' => $data['code'],
            'theme' => $data['theme'],
            'viewport' => $data['viewport'],
            'name' => $data['name'] ?? 'Untitled',
            'is_public' => $data['is_public'] ?? false,
        ]);
    }
    
    public function loadSession(string $sessionId): ?PlaygroundSession
    {
        return PlaygroundSession::where('id', $sessionId)
            ->orWhere('slug', $sessionId)
            ->first();
    }
    
    public function getUserSessions(User $user): Collection
    {
        return PlaygroundSession::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
    
    public function deleteSession(PlaygroundSession $session): void
    {
        $session->delete();
    }
    
    public function createShareLink(PlaygroundSession $session): string
    {
        $share = PlaygroundShare::create([
            'session_id' => $session->id,
            'token' => Str::random(32),
            'expires_at' => now()->addDays(30),
        ]);
        
        return route('playground.shared', $share->token);
    }
    
    public function loadSharedSession(string $token): ?PlaygroundSession
    {
        $share = PlaygroundShare::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();
        
        return $share?->session;
    }
}
```

---

# Code Generation Details

## Blade Code Generator

```php
class BladeCodeGenerator
{
    public function generate(array $components): string
    {
        $code = "@extends('layouts.app')\n\n";
        $code .= "@section('content')\n";
        $code .= "    <div class=\"container mx-auto p-4\">\n";
        
        foreach ($components as $component) {
            $code .= $this->generateComponent($component) . "\n\n";
        }
        
        $code .= "    </div>\n";
        $code .= "@endsection";
        
        return $code;
    }
    
    private function generateComponent(array $component): string
    {
        $tag = "x-gsm-{$component['type']}";
        $attributes = $this->buildAttributes($component['props']);
        
        if (!empty($component['slots'])) {
            return $this->generateWithSlots($tag, $attributes, $component['slots']);
        }
        
        return "        <{$tag}{$attributes} />";
    }
    
    private function buildAttributes(array $props): string
    {
        $attributes = [];
        
        foreach ($props as $key => $value) {
            if (is_bool($value)) {
                $attributes[] = $value ? ":{$key}" : '';
            } elseif (is_string($value)) {
                $attributes[] = "{$key}=\"{$value}\"";
            } elseif (is_array($value)) {
                $attributes[] = ":{$key}=\"" . addslashes(json_encode($value)) . "\"";
            }
        }
        
        return ' ' . implode(' ', array_filter($attributes));
    }
    
    private function generateWithSlots(string $tag, string $attributes, array $slots): string
    {
        $code = "        <{$tag}{$attributes}>\n";
        
        foreach ($slots as $slotName => $slotContent) {
            if ($slotName === 'default') {
                $code .= "            {$slotContent}\n";
            } else {
                $code .= "            <x-slot:{$slotName}>\n";
                $code .= "                {$slotContent}\n";
                $code .= "            </x-slot:{$slotName}>\n";
            }
        }
        
        $code .= "        </{$tag}>";
        
        return $code;
    }
}
```

## Livewire Code Generator

```php
class LivewireCodeGenerator
{
    public function generate(array $components, string $name): array
    {
        $className = Str::studly($name);
        
        $php = $this->generatePhpClass($className, $components);
        $blade = $this->generateBladeView($components);
        
        return [
            'php' => $php,
            'blade' => $blade,
            'wire' => "livewire:{$this->kebabCase($name)}",
        ];
    }
    
    private function generatePhpClass(string $className, array $components): string
    {
        $properties = [];
        $methods = [];
        
        foreach ($components as $component) {
            foreach ($component['props'] as $key => $value) {
                if (str_starts_with($key, 'wire:')) {
                    $property = substr($key, 5);
                    $properties[] = "public \${$property} = " . var_export($value, true) . ";";
                }
            }
            
            foreach ($component['events'] as $event) {
                $methods[] = $this->generateEventMethod($event);
            }
        }
        
        $propertiesStr = implode("\n    ", $properties);
        $methodsStr = implode("\n\n    ", $methods);
        
        return <<<PHP
        <?php
        
        namespace App\\Livewire;
        
        use Livewire\\Component;
        
        class {$className} extends Component
        {
            {$propertiesStr}
        
            {$methodsStr}
        
            public function render()
            {
                return view('livewire.' . Str::kebab('{$className}'));
            }
        }
        PHP;
    }
    
    private function generateBladeView(array $components): string
    {
        $code = "<div>\n";
        
        foreach ($components as $component) {
            $tag = "x-gsm-{$component['type']}";
            $attributes = $this->buildAttributes($component['props']);
            
            $code .= "    <{$tag}{$attributes} />\n";
        }
        
        $code .= "</div>";
        
        return $code;
    }
    
    private function generateEventMethod(string $event): string
    {
        $methodName = Str::camel('handle_' . $event);
        
        return <<<PHP
        public function {$methodName}(\$value)
        {
            // Handle {$event}
        }
        PHP;
    }
}
```

---

# Collaboration Features Details

## Share Links

```php
class ShareService
{
    public function createShareLink(PlaygroundSession $session, array $options = []): ShareLink
    {
        $share = ShareLink::create([
            'session_id' => $session->id,
            'token' => Str::random(32),
            'created_by' => auth()->id(),
            'expires_at' => $options['expires_at'] ?? now()->addDays(30),
            'is_editable' => $options['is_editable'] ?? false,
            'password' => isset($options['password']) ? bcrypt($options['password']) : null,
        ]);
        
        return $share;
    }
    
    public function accessShareLink(string $token, string $password = null): ?PlaygroundSession
    {
        $share = ShareLink::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();
        
        if (!$share) {
            return null;
        }
        
        if ($share->password && !Hash::check($password, $share->password)) {
            return null;
        }
        
        // Increment access count
        $share->increment('access_count');
        
        return $share->session;
    }
    
    public function getShareAnalytics(ShareLink $share): array
    {
        return [
            'access_count' => $share->access_count,
            'last_accessed' => $share->last_accessed_at,
            'created_at' => $share->created_at,
            'expires_at' => $share->expires_at,
        ];
    }
}
```

## Fork System

```php
class ForkService
{
    public function forkSession(PlaygroundSession $original, User $user): PlaygroundSession
    {
        $forked = PlaygroundSession::create([
            'user_id' => $user->id,
            'code' => $original->code,
            'theme' => $original->theme,
            'viewport' => $original->viewport,
            'name' => "{$original->name} (Fork)",
            'forked_from' => $original->id,
        ]);
        
        // Notify original owner
        if ($original->user_id !== $user->id) {
            Notification::send(
                $original->user,
                new SessionForkedNotification($original, $forked)
            );
        }
        
        return $forked;
    }
    
    public function getForks(PlaygroundSession $session): Collection
    {
        return PlaygroundSession::where('forked_from', $session->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function getForkTree(PlaygroundSession $session): array
    {
        $tree = [
            'session' => $session,
            'forks' => [],
        ];
        
        $forks = $this->getForks($session);
        
        foreach ($forks as $fork) {
            $tree['forks'][] = $this->getForkTree($fork);
        }
        
        return $tree;
    }
}
```

---

# Performance Optimization Details

## Lazy Loading

```javascript
class LazyLoader {
    constructor() {
        this.components = new Map();
        this.loadedCategories = new Set();
    }
    
    async loadComponent(type) {
        if (this.components.has(type)) {
            return this.components.get(type);
        }
        
        const component = await this.fetchComponent(type);
        this.components.set(type, component);
        
        return component;
    }
    
    async loadCategory(category) {
        if (this.loadedCategories.has(category)) {
            return;
        }
        
        const components = await this.fetchCategory(category);
        
        components.forEach(component => {
            this.components.set(component.type, component);
        });
        
        this.loadedCategories.add(category);
    }
    
    async fetchComponent(type) {
        const response = await fetch(`/api/playground/components/${type}`);
        return response.json();
    }
    
    async fetchCategory(category) {
        const response = await fetch(`/api/playground/categories/${category}`);
        return response.json();
    }
}
```

## Virtual Scrolling

```javascript
class VirtualScroller {
    constructor(container, itemHeight) {
        this.container = container;
        this.itemHeight = itemHeight;
        this.items = [];
        this.visibleItems = [];
        this.scrollTop = 0;
        
        this.init();
    }
    
    init() {
        this.container.style.overflow = 'auto';
        this.container.addEventListener('scroll', () => {
            this.onScroll();
        });
        
        this.content = document.createElement('div');
        this.content.style.position = 'relative';
        this.container.appendChild(this.content);
    }
    
    setItems(items) {
        this.items = items;
        this.content.style.height = `${items.length * this.itemHeight}px`;
        this.render();
    }
    
    onScroll() {
        this.scrollTop = this.container.scrollTop;
        this.render();
    }
    
    render() {
        const startIndex = Math.floor(this.scrollTop / this.itemHeight);
        const endIndex = Math.min(
            startIndex + Math.ceil(this.container.clientHeight / this.itemHeight) + 1,
            this.items.length
        );
        
        this.visibleItems = this.items.slice(startIndex, endIndex);
        
        // Update DOM
        this.content.innerHTML = '';
        
        this.visibleItems.forEach((item, index) => {
            const element = this.createItemElement(item);
            element.style.position = 'absolute';
            element.style.top = `${(startIndex + index) * this.itemHeight}px`;
            element.style.width = '100%';
            this.content.appendChild(element);
        });
    }
    
    createItemElement(item) {
        const div = document.createElement('div');
        div.className = 'virtual-item';
        div.innerHTML = item.html;
        return div;
    }
}
```

## Debounced Preview Updates

```javascript
class DebouncedUpdater {
    constructor(callback, delay = 300) {
        this.callback = callback;
        this.delay = delay;
        this.timer = null;
        this.pendingUpdate = null;
    }
    
    update(code) {
        this.pendingUpdate = code;
        
        if (this.timer) {
            clearTimeout(this.timer);
        }
        
        this.timer = setTimeout(() => {
            this.callback(this.pendingUpdate);
            this.pendingUpdate = null;
        }, this.delay);
    }
    
    cancel() {
        if (this.timer) {
            clearTimeout(this.timer);
            this.timer = null;
        }
        
        this.pendingUpdate = null;
    }
    
    flush() {
        if (this.pendingUpdate) {
            this.callback(this.pendingUpdate);
            this.pendingUpdate = null;
        }
        
        if (this.timer) {
            clearTimeout(this.timer);
            this.timer = null;
        }
    }
}
```

---

# Security Details

## Sandboxed Preview

```php
class SandboxedPreview
{
    private const ALLOWED_TAGS = [
        'div', 'span', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'a', 'img', 'ul', 'ol', 'li', 'table', 'tr', 'td', 'th',
        'form', 'input', 'select', 'textarea', 'button', 'label',
        'section', 'article', 'aside', 'header', 'footer', 'nav',
        'main', 'figure', 'figcaption', 'details', 'summary',
    ];
    
    private const DISALLOWED_ATTRIBUTES = [
        'onclick', 'ondblclick', 'onmousedown', 'onmouseup', 'onmouseover',
        'onmousemove', 'onmouseout', 'onkeypress', 'onkeydown', 'onkeyup',
        'onfocus', 'onblur', 'onsubmit', 'onreset', 'onselect', 'onchange',
    ];
    
    public function sanitize(string $html): string
    {
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        
        $this->sanitizeNode($dom->documentElement);
        
        return $dom->saveHTML();
    }
    
    private function sanitizeNode(DOMNode $node): void
    {
        if ($node instanceof DOMElement) {
            // Remove disallowed tags
            if (!in_array(strtolower($node->tagName), self::ALLOWED_TAGS)) {
                $node->parentNode->removeChild($node);
                return;
            }
            
            // Remove disallowed attributes
            $attributes = [];
            for ($i = 0; $i < $node->attributes->length; $i++) {
                $attribute = $node->attributes->item($i);
                if (!in_array(strtolower($attribute->name), self::DISALLOWED_ATTRIBUTES)) {
                    $attributes[$attribute->name] = $attribute->value;
                }
            }
            
            // Remove all attributes and re-add allowed ones
            while ($node->attributes->length > 0) {
                $node->removeAttribute($node->attributes->item(0)->name);
            }
            
            foreach ($attributes as $name => $value) {
                $node->setAttribute($name, $value);
            }
        }
        
        // Process children
        $children = [];
        for ($i = 0; $i < $node->childNodes->length; $i++) {
            $children[] = $node->childNodes->item($i);
        }
        
        foreach ($children as $child) {
            $this->sanitizeNode($child);
        }
    }
}
```

## Rate Limiting

```php
class PlaygroundRateLimiter
{
    public function check(User $user): bool
    {
        $key = "playground:rate:{$user->id}";
        
        $requests = Cache::get($key, 0);
        
        if ($requests >= 100) { // 100 requests per minute
            return false;
        }
        
        Cache::put($key, $requests + 1, now()->addMinute());
        
        return true;
    }
    
    public function getRemainingRequests(User $user): int
    {
        $key = "playground:rate:{$user->id}";
        $requests = Cache::get($key, 0);
        
        return max(0, 100 - $requests);
    }
    
    public function reset(User $user): void
    {
        Cache::forget("playground:rate:{$user->id}");
    }
}
```

---

# API Contracts Details

## Playground API Specification

```yaml
openapi: 3.0.0
info:
  title: GsmUi Playground API
  version: 1.0.0
  description: API for the GsmUi Playground

paths:
  /api/playground/render:
    post:
      summary: Render code preview
      tags: [Preview]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - code
              properties:
                code:
                  type: string
                theme:
                  type: string
                  enum: [light, dark]
                viewport:
                  type: string
                  enum: [desktop, tablet, mobile]
      responses:
        '200':
          description: Rendered HTML
          content:
            application/json:
              schema:
                type: object
                properties:
                  html:
                    type: string
                  errors:
                    type: array
                    items:
                      type: object
                  warnings:
                    type: array
                    items:
                      type: object

  /api/playground/components:
    get:
      summary: List available components
      tags: [Components]
      responses:
        '200':
          description: Component list
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: '#/components/schemas/Component'

  /api/playground/components/{type}:
    get:
      summary: Get component details
      tags: [Components]
      parameters:
        - name: type
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Component details
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ComponentDetail'

  /api/playground/sessions:
    get:
      summary: List user sessions
      tags: [Sessions]
      security:
        - bearerAuth: []
      responses:
        '200':
          description: Session list

    post:
      summary: Save session
      tags: [Sessions]
      security:
        - bearerAuth: []
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - code
              properties:
                code:
                  type: string
                name:
                  type: string
                theme:
                  type: string
                viewport:
                  type: string
                is_public:
                  type: boolean
      responses:
        '201':
          description: Session saved

  /api/playground/sessions/{id}:
    get:
      summary: Get session
      tags: [Sessions]
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Session details

    put:
      summary: Update session
      tags: [Sessions]
      security:
        - bearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Session updated

    delete:
      summary: Delete session
      tags: [Sessions]
      security:
        - bearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '204':
          description: Session deleted

  /api/playground/share:
    post:
      summary: Create share link
      tags: [Sharing]
      security:
        - bearerAuth: []
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - session_id
              properties:
                session_id:
                  type: string
                expires_at:
                  type: string
                  format: date-time
                is_editable:
                  type: boolean
                password:
                  type: string
      responses:
        '201':
          description: Share link created
          content:
            application/json:
              schema:
                type: object
                properties:
                  url:
                    type: string
                  token:
                    type: string

components:
  schemas:
    Component:
      type: object
      properties:
        type:
          type: string
        name:
          type: string
        category:
          type: string
        description:
          type: string
        props:
          type: object
        events:
          type: array
          items:
            type: string
        slots:
          type: array
          items:
            type: string

    ComponentDetail:
      allOf:
        - $ref: '#/components/schemas/Component'
        - type: object
          properties:
            examples:
              type: array
              items:
                type: object
                properties:
                  name:
                    type: string
                  code:
                    type: string
            documentation:
              type: string

  securitySchemes:
    bearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
```

---

# Admin Features Details

## Template Management

```php
class PlaygroundTemplateManagement
{
    public function createTemplate(array $data): PlaygroundTemplate
    {
        return PlaygroundTemplate::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'],
            'code' => $data['code'],
            'category' => $data['category'],
            'difficulty' => $data['difficulty'] ?? 'beginner',
            'tags' => $data['tags'] ?? [],
            'is_featured' => $data['is_featured'] ?? false,
            'created_by' => auth()->id(),
        ]);
    }
    
    public function updateTemplate(PlaygroundTemplate $template, array $data): PlaygroundTemplate
    {
        $template->update($data);
        
        return $template;
    }
    
    public function deleteTemplate(PlaygroundTemplate $template): void
    {
        $template->delete();
    }
    
    public function getFeaturedTemplates(): Collection
    {
        return Cache::remember('featured_templates', 3600, function () {
            return PlaygroundTemplate::where('is_featured', true)
                ->orderBy('usage_count', 'desc')
                ->limit(10)
                ->get();
        });
    }
    
    public function incrementUsage(PlaygroundTemplate $template): void
    {
        $template->increment('usage_count');
    }
}
```

## Analytics Dashboard

```php
class PlaygroundAnalytics
{
    public function getOverview(int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return [
            'total_sessions' => PlaygroundSession::where('created_at', '>=', $startDate)->count(),
            'unique_users' => PlaygroundSession::where('created_at', '>=', $startDate)
                ->distinct('user_id')
                ->count(),
            'total_shares' => PlaygroundShare::where('created_at', '>=', $startDate)->count(),
            'total_forks' => PlaygroundSession::where('created_at', '>=', $startDate)
                ->whereNotNull('forked_from')
                ->count(),
            'avg_session_duration' => $this->getAvgSessionDuration($startDate),
            'top_components' => $this->getTopComponents($startDate),
        ];
    }
    
    public function getUsageChart(int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        $usage = DB::table('playground_sessions')
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as sessions')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return [
            'labels' => $usage->pluck('date'),
            'data' => $usage->pluck('sessions'),
        ];
    }
    
    private function getTopComponents(Carbon $startDate): array
    {
        $sessions = PlaygroundSession::where('created_at', '>=', $startDate)
            ->pluck('code');
        
        $components = [];
        
        foreach ($sessions as $code) {
            preg_match_all('/<x-gsm-(\w+)/', $code, $matches);
            foreach ($matches[1] as $match) {
                $components[$match] = ($components[$match] ?? 0) + 1;
            }
        }
        
        arsort($components);
        
        return array_slice($components, 0, 10, true);
    }
    
    private function getAvgSessionDuration(Carbon $startDate): float
    {
        $durations = DB::table('playground_sessions')
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('ended_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, ended_at)) as duration')
            ->value('duration');
        
        return $durations ?? 0;
    }
}
```

## Usage Statistics

```php
class UsageStatistics
{
    public function getComponentStats(): array
    {
        return Cache::remember('component_stats', 3600, function () {
            $sessions = PlaygroundSession::pluck('code');
            
            $stats = [];
            
            foreach ($sessions as $code) {
                preg_match_all('/<x-gsm-(\w+)/', $code, $matches);
                foreach ($matches[1] as $match) {
                    $stats[$match] = ($stats[$match] ?? 0) + 1;
                }
            }
            
            arsort($stats);
            
            return $stats;
        });
    }
    
    public function getThemeStats(): array
    {
        return PlaygroundSession::select('theme', DB::raw('COUNT(*) as count'))
            ->groupBy('theme')
            ->get()
            ->pluck('count', 'theme')
            ->toArray();
    }
    
    public function getViewportStats(): array
    {
        return PlaygroundSession::select('viewport', DB::raw('COUNT(*) as count'))
            ->groupBy('viewport')
            ->get()
            ->pluck('count', 'viewport')
            ->toArray();
    }
    
    public function getExportStats(): array
    {
        return DB::table('playground_exports')
            ->select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type')
            ->toArray();
    }
}
```

## Performance Monitoring

```php
class PerformanceMonitor
{
    public function getRenderTimes(): array
    {
        return Cache::remember('render_times', 3600, function () {
            return DB::table('playground_render_times')
                ->selectRaw('AVG(render_time) as avg, MIN(render_time) as min, MAX(render_time) as max')
                ->first();
        });
    }
    
    public function getSlowRenders(int $threshold = 1000): Collection
    {
        return DB::table('playground_render_times')
            ->where('render_time', '>', $threshold)
            ->orderBy('render_time', 'desc')
            ->limit(100)
            ->get();
    }
    
    public function getErrorRate(): float
    {
        $total = DB::table('playground_sessions')->count();
        $errors = DB::table('playground_errors')->count();
        
        return $total > 0 ? ($errors / $total) * 100 : 0;
    }
    
    public function getRecentErrors(int $limit = 50): Collection
    {
        return DB::table('playground_errors')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
```

---

# Success Metrics Details

## Key Performance Indicators

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Monthly Sessions | 5,000 | 10,000+ | Session count |
| Preview Render Time | 600ms | <500ms | Average render time |
| Code Export Usage | 60% | 70%+ | Exports / Sessions |
| Community Templates | 30 | 50+ | Template count |
| User Satisfaction | 4.3/5 | 4.5/5 | Survey score |
| Session Duration | 4 minutes | 5 minutes | Average time |
| Share Rate | 10% | 15%+ | Shares / Sessions |
| Fork Rate | 5% | 10%+ | Forks / Sessions |

## Performance Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Initial Load | 2s | <1.5s | First contentful paint |
| Editor Responsiveness | 100ms | <50ms | Input delay |
| Preview Update | 400ms | <300ms | Update latency |
| Save Time | 500ms | <300ms | Save operation |
| Share Link Generation | 300ms | <200ms | Generation time |

## User Engagement Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Return Users | 40% | 50%+ | Monthly retention |
| Feature Adoption | 60% | 75%+ | Users using advanced features |
| Template Usage | 50% | 70%+ | Users starting from templates |
| Export Format | 80% Blade | Balanced | Export distribution |

---

# Next Document

**18 - Theme Generator** — Visual theme creation and customization tool.
